<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->header = $this->view->render('header.phtml');
        $this->view->footer = $this->view->render('footer.phtml');
    }

    public function indexAction()
    {
        $form = new Application_Form_Login();
        
        if ($this->getRequest()->isPost())
        {
	        if ($form->isValid($_POST))
	        {
	        	$user = new Application_Model_User();
	        	
	        	if (!$user->authenticate($form->getElement('username')->getValue(), $form->getElement('password')->getValue()))
	        	{
	        		$form->addError('Authentication failed');
	        	}
	        	else 
	        	{
	        		echo 'Authenticated as: ' . $user->getUsername();
	        	}
	        }
        }
        
        $this->view->form = $form;
	   	$form->render($this->view);
        
    }


}

