<?php

class UserModelTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    
	public function testNoAuthNoUsername()
    {
    	$user = new Application_Model_User();
    	$this->assertNull($user->getUsername());
    }
    
	public function testNoAuthNoPlayer()
    {
    	$user = new Application_Model_User();
    	$this->assertNull($user->getPlayer());
    }
    
    public function testFailedAuth()
    {
    	$user = new Application_Model_User();
    	$this->assertFalse($user->authenticate('thisisafailed', 'login'));
    }
    
	public function testFailedAuthNoUsername()
    {
    	$user = new Application_Model_User();
    	$this->assertFalse($user->authenticate('thisisafailed', 'login'));
    	$this->assertNull($user->getUsername());
    }
    
	public function testFailedAuthNoPlayer()
    {
    	$user = new Application_Model_User();
    	$this->assertFalse($user->authenticate('thisisafailed', 'login'));
    	$this->assertNull($user->getPlayer());
    }
}
