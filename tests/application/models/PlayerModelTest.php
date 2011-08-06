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
}
