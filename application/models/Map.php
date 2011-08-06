<?php

class Application_Model_Map
{

	private
		$_generatorPath;
	
	public function __construct()
	{
		$path = Zend_Registry::get('config')->get('c10t')->get('path');
		
		if (!$path || !file_exists($path)) {
			throw new Exception('No path to c10t defined in config: try adding \'c10t.path\'');
		}
		
		$this->_generatorPath = Zend_Registry::get('config')->get('c10t')->get('path');
	}

	/**
	 * Generate the map file and put it in the temp dir
	 */
	public function regenerate()
	{
		exec($this->_generatorPath . ' -w ' . Zend_Registry::get('config')->get('minecraft')->get('worldPath') . '/world -o ' . $this->getMapPath());
	}
	
	/**
	 * Outputs a png header followed by the contents of the map file
	 * 
	 * @return void
	 */
	public function outputMap()
	{
		if (file_exists($this->getMapPath()))
		{
			header ('Content-Type: image/png');
			readfile($this->getMapPath());
		}
		else {
			throw new Exception('Map file not present');
		}
	}
	
	/**
	 * Returns the path to the map file
	 * 
	 * @return string
	 */
	private function getMapPath()
	{
		return realpath(APPLICATION_PATH . '/../tmp') . '/map.png';
	}
}

