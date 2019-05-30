<?php

class PublicController extends Zend_Controller_Action
{

    protected $_catalogModel;

    public function init() {
        /* Initialize action controller here */
        $this->_helper->layout->setLayout('public');
    }

    public function indexAction() {
        // action body
    }


    public function catalogAction(){




    }

}