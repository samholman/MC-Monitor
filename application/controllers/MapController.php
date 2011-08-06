<?php

class MapController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $map = new Application_Model_Map();
        $map->outputMap();
        exit;
    }


}

