<?php

class ServerModelTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->application->bootstrap();
        parent::setUp();
    }
    
    public function testStartStop()
    {
    	$server = new Application_Model_Server();
    	$this->assertFalse($server->isRunning());
    	
    	$this->assertTrue($server->start());
    	var_dump($server->getOutput());
    	
    	$this->assertTrue($server->isRunning());
    	$server->stop();
    }
}
