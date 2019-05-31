<?php

class AdminController extends Zend_Controller_Action
{
    protected $_database;

    public function init() {
        $this->_database = new Application_Model_Database();
    }

    public function indexAction() {
        // action body
    }


}