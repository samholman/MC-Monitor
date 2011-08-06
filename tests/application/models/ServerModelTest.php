<?php

class ServerModelTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->application->bootstrap();
        parent::setUp();
    }
    
    public function testGetOnlinePlayers()
    {
    	$server = new Application_Model_Server();
    	
    	if (!$server->isRunning()) {
    		//$this->markTestSkipped('Server not running.');
    	}
    	
    	$playersArray = $server->getOnlinePlayers();
    	
    	$this->assertInternalType('array', $playersArray);
    	//print_r($playersArray);
    }
}
