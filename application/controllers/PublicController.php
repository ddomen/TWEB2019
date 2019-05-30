<?php

class PublicController extends Zend_Controller_Action
{

    protected $_catalogModel;

    public function init() {
        $this->_helper->layout->setLayout('public');
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