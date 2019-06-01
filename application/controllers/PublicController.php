<?php

class PublicController extends Zend_Controller_Action
{
    protected $_database;
    
    public function init() {
        $this->_helper->layout->setLayout('public');
        $this->_database = new Application_Model_DBContext();
    }

    public function indexAction() {
        $this->view->assign(array('topFaqs' => $this->_database->getTopFaq()));
    }
    
    public function aboutusAction(){
        
    }
          
    public function contactsAction(){
        
    }


    public function catalogAction(){
        $this->view->assign(array('catalog' => $this->_database->getCatalog()));
    }

    public function rulesAction(){

    }

    public function faqAction(){

    }

    public function loginAction(){

    }

    public function signinAction(){

    }

}