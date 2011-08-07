<?php

class SkinController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$user = !empty($_GET['user']) ? $_GET['user'] : null;
		
		$skin = new Application_Model_PlayerSkin($user);
		
		$skin->getTexture();
		$skin->render();
		
    }
}

