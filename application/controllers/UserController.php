<?php

class UserController extends Zend_Controller_Action
{
    protected $_database;

    public function init() {
        $this->_database = new Application_Model_DBContext();
        $this->view->headScript()->appendFile($this->view->baseUrl('js/messanger.js'));
        $this->_helper->layout->setLayout('user');
    }

    public function indexAction() {
        // action body
    }

    public function aboutusAction(){
           
    }
          
    public function contactsAction(){
        
    }


    public function catalogAction(){

    }

    public function rulesAction(){

    }

}