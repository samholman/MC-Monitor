<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $this->view->header = $this->view->render('header.phtml');
        $this->view->footer = $this->view->render('footer.phtml');
    }
	
    /**
     * Index action redirects to login or dashboard depending on whether the user has auth'd with their MC account
     * 
     * @return void
     */
    public function indexAction()
    {
    	$session = new Zend_Session_Namespace();
    	
        if (!$session->username) {
        	$this->_forward('index', 'login');
        }
        else {
        	$this->_forward('dashboard');
        }
    }
    
    /**
     * The main UI action
     * 
     * @return void
     */
    public function dashboardAction()
    {
    	$playerList = Application_Model_PlayerList::get();
    	$this->view->playerList = $playerList->getIterator();
    	
    	$server = new Application_Model_Server();
    	$this->view->serverProperties = $server->getProperties();
    }
}
