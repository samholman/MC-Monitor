<?php

class Application_Model_PlayerSkin
{
	private
		$_username;
	
	public function __construct($username)
	{
		$this->_username = $username;
	}

	/**
	 * Downloads the players skin to the tmp directory
	 * 
	 * @return void
	 */
	public function getTexture()
	{
		$path = realpath(APPLICATION_PATH . '/../tmpskins') . '/' . $this->_username . '.png';
		
		$data = file_get_contents('http://s3.amazonaws.com/MinecraftSkins/' . $this->_username . '.png');
		file_put_contents($path, $data);
	}
	
	/**
	 * Uses GD to render a model of the player and output the result
	 */
	public function render()
	{
		
	}
}

