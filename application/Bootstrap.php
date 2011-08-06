<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initRouter ()
	{
	    if (PHP_SAPI == 'cli')
	    {
	    	//Small hack to include the router (bored of looking for how the autoloader works in zend)
	    	include ('application/routers/Cli.php');
	    	
	        $this->bootstrap ('frontcontroller');
	        $front = $this->getResource('frontcontroller');
	        $front->setRouter (new Application_Router_Cli ());
	        $front->setRequest (new Zend_Controller_Request_Simple ());
	    }
	}

}

