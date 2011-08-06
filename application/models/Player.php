<?php

class Application_Model_Player
{

	/**
	 * Loads a players data
	 * 
	 * @param string $username
	 * @return bool
	 */
	public function load($username)
	{
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
}

