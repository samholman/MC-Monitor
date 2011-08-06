<?php

/**
 * The server model handles starting and stopping the server, etc
 */
class Application_Model_Server
{
	private
		$_pid,
		$_process,
		$_pipes,
		$_descriptorSpec = array(
			array('pipe', 'r'),
			array('pipe', 'w'),
			array('pipe', 'r'),
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
		
		$this->_process = proc_open('java -Xmx1024M -Xms1024M -jar ' . $jarPath . ' ', $this->_descriptorSpec, $this->_pipes, $worldPath);
		
		if ($this->isRunning())
		{
			stream_set_blocking($this->_pipes[0], false);
			stream_set_blocking($this->_pipes[1], false);
			stream_set_blocking($this->_pipes[2], false);
			fwrite($this->_pipes[0], 'list');
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
		
		//$status = proc_get_status($this->_process);
		//exec('kill ' . $status['pid']);
		return proc_close($this->_process);
	}
	
	/**
	 * Returns the server output
	 * 
	 * @return string
	 */
	public function getOutput()
	{
		if ($this->isRunning()) {
			return stream_get_contents($this->_pipes[2]);
		}
	}
}
