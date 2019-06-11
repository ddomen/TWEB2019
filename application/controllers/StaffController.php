<?php

class StaffController extends Zend_Controller_Action
{

    protected $_database;
    protected $_redirector;

    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        if(!$this->view->acl->isAllowed($this->view->currentRole, null, 'Staff')){ $this->_redirector->gotoSimple('auth', 'error'); }

        $this->view->headScript()->appendFile($this->view->baseUrl('js/messanger.js'));
        $this->view->layout = 'staff';
    }

    public function indexAction() {
        if($this->view->currentRoleLevel >= 3){ $this->_redirector->gotoSimple('index', 'admin'); }
        $this->view->assign(array('topFaqs' => $this->_database->getTopFaq()));
        $this->_helper->viewRenderer->renderBySpec('index', array('controller' => 'public'));
    }

<<<<<<< HEAD
    public function insertAction(){
        //action che richiama la view per l'inserimento di una macchina
    }
=======
    public function aboutusAction(){ $this->_helper->viewRenderer->renderBySpec('aboutus', array('controller' => 'public')); }
    public function contactsAction(){ $this->_helper->viewRenderer->renderBySpec('contacts', array('controller' => 'public')); }
    public function rulesAction(){ $this->_helper->viewRenderer->renderBySpec('rules', array('controller' => 'public')); }
    public function faqAction(){ $this->_helper->viewRenderer->renderBySpec('faq', array('controller' => 'public')); }

>>>>>>> 04f0ec58ce6d56418480babc313085709cc1b224
}