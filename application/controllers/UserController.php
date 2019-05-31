<?php

class UserController extends Zend_Controller_Action
{

    public function init() {
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