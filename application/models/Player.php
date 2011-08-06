<?php

class Application_Model_Player
{
	private 
		$_username;

	
	/**
	 * Loads a players data
	 * 
	 * @param string $username
	 * @return bool
	 */
	public function load($username)
	{
		$this->_username = $username;
		
		if (file_exists($this->getDatFilePath()))
		{
			$data = $this->getPlayerData();
			
			//$data = gzfile($this->getDatFilePath());
			
			return true;
		}
		
		return false;
	}

	/**
	 * Checks if a player is online
	 * 
	 * @return bool
	 */
	public function isOnline()
	{
		return false;
	}
	
	/**
	 * Returns a players location object or null if not avaliable
	 * 
	 * @return Application_Model_Player_Location
	 */
	public function getLocation()
	{
		return null;
	}
	
	/**
	 * Returns a players skin object or null if not avaliable
	 * 
	 * @return Application_Model_Player_Skin
	 */
	public function getSkin()
	{
		return null;
	}
	
	/**
	 * Returns a players health or null if not avaliable
	 * 
	 * @return int
	 */
	public function getHealth()
	{
		return null;
	}
	
	/**
	 * Returns the filepath for the players dat file
	 * 
	 * @return string
	 */
	private function getDatFilePath()
	{
		return Zend_Registry::get('config')->get('minecraft')->get('worldPath') . '/world/players/' . $this->_username . '.dat';
	}
	
	/**
	 * Returns a loaded player data object
	 * 
	 * @return Application_Model_PlayerData
	 */
	private function getPlayerData()
	{
		$data = new Application_Model_PlayerData();
		$data->load($this->getDatFilePath());
		
		return $data;
	}
}

