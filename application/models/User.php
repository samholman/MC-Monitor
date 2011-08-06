<?php

class Application_Model_User
{
	private 
		$_username;
		
	public function __construct() {}
	
	/**
	 * Authenticates the user, if successfull returns a 
	 * 
	 * @param string $username
	 * @param string $password
	 * @return bool
	 */
	public function authenticate($username, $password)
	{
		return false;
	}
	
	/**
	 * Returns the username of the authenticated player
	 * 
	 * @return string
	 */
	public function getUsername()
	{
		return $this->_username;
	}
	
	/**
	 * Gets the player object for the authenticated player or null if no object
	 * 
	 * @return Application_Model_Player
	 */
	public function getPlayer()
	{
		return null;
	}
}

