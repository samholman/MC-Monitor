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
		$client = new Zend_Http_Client();
		$client->setUri('https://login.minecraft.net/');
		
		$client->setParameterPost('user', $username);
		$client->setParameterPost('password', $password);
		$client->setParameterPost('version', 9999);
		
		$client->setHeaders('Content-Type', 'application/x-www-form-urlencoded');
		
		$response = $client->request('POST');
		
		$body = $response->getBody();
		
		$matches = array();
		preg_match('/(\d*):(\w*):(\w*):(\d*)/', $body, $matches);
		
		if (!empty($matches))
		{
			$this->_username = $matches[3];
			return true;
		}
		
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

