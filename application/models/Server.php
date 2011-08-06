<?php

/**
 * The server model handles starting and stopping the server, etc
 */
class Application_Model_Server
{
	const
		COMMANDS_FILE = '/tmp/mc-monitor-commands',
		RESULTS_FILE  = '/tmp/mc-monitor-results';
	
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
		return is_resource($this->_process);
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
		
		if ($this->isRunning())
		{
			stream_set_blocking($this->_pipes[0], false);
			stream_set_blocking($this->_pipes[1], false);
			stream_set_blocking($this->_pipes[2], false);
			
			while (true)
			{
				sleep(1);
				
				$commands = file(self::COMMANDS_FILE);
				file_put_contents(self::COMMANDS_FILE, '');
				
				if (is_array($commands) && !empty($commands))
				{
					foreach ($commands as $command) {
						fwrite($this->_pipes[0], $command);
					}
				}
				
				$output = stream_get_contents($this->_pipes[1]);
				
				if (!empty($output)) {
					file_put_contents(self::RESULTS_FILE, trim($output));
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
		fclose($this->_pipes[0]);
		fclose($this->_pipes[1]);
		fclose($this->_pipes[2]);
		
		$status = proc_get_status($this->_process);
		exec('kill ' . $status['pid']);
		return proc_close($this->_process);
	}
	
	/**
	 * Runs a command on the server process and returns the result
	 * 
	 * @param string $command
	 * @return string
	 */
	public function runCommand($command)
	{
		file_put_contents(self::COMMANDS_FILE, trim($command) . "\n");
		$result = false;
		
		while (!$result) {
			$result = file_get_contents(self::RESULTS_FILE);
		}
		
		file_put_contents(self::RESULTS_FILE, '');
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
}
