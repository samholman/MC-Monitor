<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
        $this->view->header = $this->view->render('header.phtml');
        $this->view->footer = $this->view->render('footer.phtml');
    }

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
    
    public function dashboardAction()
    {
        $playerList = Application_Model_PlayerList::get();
        $this->view->playerList = $playerList->getIterator();
    }
}
