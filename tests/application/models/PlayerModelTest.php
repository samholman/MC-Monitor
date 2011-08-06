<?php

class PlayerModelTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    
	public function testCreatePlayer()
    {
    	$player = new Application_Model_Player();
    }
    
	public function testLoadPlayer()
    {
    	$player = new Application_Model_Player();
    	$this->assertFalse($player->load('badplayer'));
    }
    
	public function testDefaultOfflinePlayer()
    {
    	$player = new Application_Model_Player();
    	$this->assertFalse($player->isOnline());
    }
    
	public function testDefaultPlayerLocation()
    {
    	$player = new Application_Model_Player();
    	$this->assertNull($player->getLocation());
    }
    
	public function testDefaultPlayerSkin()
    {
    	$player = new Application_Model_Player();
    	$this->assertNull($player->getSkin());
    }
    
	public function testDefaultPlayerHealth()
    {
    	$player = new Application_Model_Player();
    	$this->assertNull($player->getHealth());
    }
}
