<?php

class NBTFileModelTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->application->bootstrap();
        parent::setUp();
    }
    
 	public function testParser()
    {
    	$file = new Application_Model_NBTFile();
    	$data = $file->load('http://wiki.vg/nbt/test.nbt');
    	//$data = $file->load('/opt/local/minecraft/world/players/taraka.dat');
    }
	
}
