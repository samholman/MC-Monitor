<?php

/**
 * The server model handles starting and stopping the server and sending commands
 */
class Application_Model_Server
{
	const
		COMMANDS_FILE = '/../tmp/mc-monitor.commands',
		RESULTS_FILE  = '/../tmp/mc-monitor.results',
		PID_FILE  	  = '/../tmp/mc-monitor.pid';
	
	private
		$_pid,
		$_process,
		$_pipes = array(),
		$_descriptorSpec = array(
			array('pipe', 'r'),
			array('pipe', 'w'),
			array('pipe', 'w'),
		);
	
	/**
	 * Returns whether or not the Minecraft server is running
	 * 
	 * @return bool
	 */
	public function isRunning()
	{
		if (file_exists(APPLICATION_PATH . self::PID_FILE))
		{
			$pid = file_get_contents(APPLICATION_PATH . self::PID_FILE);
			
			if ($this->processExists($pid)) {
				return true;
			}
			
			//unlink(APPLICATION_PATH . self::PID_FILE);
		}
		
		return false;
	}
	
	/**
	 * Returns whether or not the process identified by pid is running
	 * 
	 * @param int $pid
	 * @return bool
	 */
	private function processExists($pid)
	{
		if (strtolower(substr(PHP_OS, 0, 3)) == 'win')
		{
			$result = exec('tasklist /FI "PID eq ' . $pid . '"');
			return substr($result, 0, 14) != 'INFO: No tasks';
		}
		else
		{
			$result = exec('ps -p ' . $pid);
			return substr($result, 0, strlen($pid)) == $pid;
		}
		
		return false;
	}
	
	/**
	 * Starts the Minecraft server, returns true on success
	 * 
	 * @return bool
	 */
	public function start()
	{
		$jarPath   = Zend_Registry::get('config')->get('minecraft')->get('serverPath');
		$worldPath = Zend_Registry::get('config')->get('minecraft')->get('worldPath');
		
		$this->_process = proc_open('java -Xmx1024M -Xms1024M -jar ' . $jarPath . ' nogui 2>&1', $this->_descriptorSpec, $this->_pipes, $worldPath);
		$status = proc_get_status($this->_process);
		file_put_contents(APPLICATION_PATH . self::PID_FILE, $status['pid']);
		
		if ($this->isRunning())
		{
			register_shutdown_function(array('Application_Model_Server', 'shutdownHandler'));
			
			stream_set_blocking($this->_pipes[0], false);
			stream_set_blocking($this->_pipes[1], false);
			stream_set_blocking($this->_pipes[2], false);
			
			while (true)
			{
				sleep(1);
				
				$commands = file(APPLICATION_PATH . self::COMMANDS_FILE);
				file_put_contents(APPLICATION_PATH . self::COMMANDS_FILE, '');
				
				if (is_array($commands) && !empty($commands))
				{
					foreach ($commands as $command) {
						fwrite($this->_pipes[0], $command);
					}
				}
				
				$output = stream_get_contents($this->_pipes[1]);
				
				if (!empty($output)) {
					file_put_contents(APPLICATION_PATH . self::RESULTS_FILE, trim($output));
				}
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Stop the minecraft server process
	 * 
	 * @return int
	 */
	public function stop()
	{
		if ($this->isRunning())
		{
			fclose($this->_pipes[0]);
			fclose($this->_pipes[1]);
			fclose($this->_pipes[2]);
			
			//$status = proc_get_status($this->_process);
			//exec('kill ' . $status['pid']);
			
			self::shutdownHandler();
			return proc_close($this->_process);
		}
	}
	
	/**
	 * Delete the temp files
	 * 
	 * @return void
	 */
	public static function shutdownHandler()
	{
		unlink(APPLICATION_PATH . self::COMMANDS_FILE);
		unlink(APPLICATION_PATH . self::RESULTS_FILE);
		unlink(APPLICATION_PATH . self::PID_FILE);
	}
	
	/**
	 * Runs a command on the server process and returns the result
	 * 
	 * @param string $command
	 * @return string
	 */
	public function runCommand($command)
	{
		if (!$this->isRunning()) {
			throw new Zend_Exception('server_not_running');
		}
		
		file_put_contents(APPLICATION_PATH . self::COMMANDS_FILE, trim($command) . "\n");
		$result = false;
		
		while (!$result) {
			$result = file_get_contents(APPLICATION_PATH . self::RESULTS_FILE);
		}
		
		file_put_contents(APPLICATION_PATH . self::RESULTS_FILE, '');
		return $result;
	}
	
	/**
	 * Returns an array of online player names
	 * 
	 * @return array
	 */
	public function getOnlinePlayers()
	{
		$playersArray = false;
		
		do
		{
			$players = $this->runCommand('list');
			
			if (substr($players, 27, 18) == 'Connected players:')
			{
				$players = substr($players, 46);
				$playersArray = explode(',', $players);
				
				foreach ($playersArray as $key => &$player)
				{
					$player = trim($player);
					
					if (empty($player)) {
						unset($playersArray[$key]);
					}
				}
			}
		}
		while (!is_array($playersArray));
		
		return $playersArray;
	}
	
	/**
	 * Fetches the server properties
	 * 
	 * @return array
	 */
	public function getProperties()
	{
		$path = Zend_Registry::get('config')->get('minecraft')->get('worldPath') . '/server.properties';
		
		if (!file_exists($path)) {
			throw new Exception('Server properties file not found');
		}
		
		$fileData = file_get_contents($path);
		
		$data = explode("\n", $fileData);
		
		$output = array();
		
		foreach ($data as $property)
		{
			if (strpos($property, '=') != false)
			{
				list($key, $value) = explode('=', $property, 2);
				$output[$key] = $value;
			}
		}
		
		return $output;
	}
}
