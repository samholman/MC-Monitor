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
		$data = file_get_contents('http://s3.amazonaws.com/MinecraftSkins/' . $this->_username . '.png');
		file_put_contents($this->getTexturePath(), $data);
	}
	
	/**
	 * Uses GD to render a model of the player and output the result
	 */
	public function render()
	{
		if (file_exists($this->getTexturePath()))
		{
			header ('Content-Type: image/png');
			$renderer = new Application_Model_SkinRenderer();
			$renderer->AssignSkinFromFile($this->getTexturePath());
			$img = $renderer->CombinedImage(5);
			imagepng($img);
			imagedestroy($img);
		}
		else {
			throw new Exception('Texture file not present');
		}
	}
	
	private function getTexturePath()
	{
		return realpath(APPLICATION_PATH . '/../tmp/skins') . '/' . $this->_username . '.png';
	}
}

