<?php

class UserModelTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    
    public function testFailedAuth()
    {
    	$user = new Application_Model_User();
    	$this->assertFalse($user->authenticate('thisisafailed', 'login'));
    }
}
