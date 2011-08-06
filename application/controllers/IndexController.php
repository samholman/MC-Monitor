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
        
    }
}
