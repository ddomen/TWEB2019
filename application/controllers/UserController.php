<?php

class UserController extends Zend_Controller_Action
{
    protected $_database;
    protected $_redirector;

    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        if(!$this->view->acl->isAllowed($this->view->currentRole, null, 'Utente')){
            $this->_redirector->gotoSimple('auth', 'error');
        }

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