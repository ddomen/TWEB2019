<?php

class PublicController extends Zend_Controller_Action
{
    protected $_database;
    protected $_redirector;
    
    public function init() {
        $this->_helper->layout->setLayout('public');
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
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