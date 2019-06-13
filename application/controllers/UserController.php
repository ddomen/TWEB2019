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
        $this->view->layout = 'user';
    }

    public function indexAction() {
        if($this->view->currentRoleLevel >= 2){ $this->_redirector->gotoSimple('index', 'staff'); }
        $this->view->assign(array('topFaqs' => $this->_database->getTopFaq()));
        $this->_helper->viewRenderer->renderBySpec('index', array('controller' => 'public'));
    }

  

    public function aboutusAction(){ $this->_helper->viewRenderer->renderBySpec('aboutus', array('controller' => 'public')); }
    public function contactsAction(){ $this->_helper->viewRenderer->renderBySpec('contacts', array('controller' => 'public')); }
    public function rulesAction(){ $this->_helper->viewRenderer->renderBySpec('rules', array('controller' => 'public')); }
    public function faqAction(){ $this->_helper->viewRenderer->renderBySpec('faq', array('controller' => 'public')); }


    public function catalogAction(){}

    public function profileAction(){
        $profileForm = new App_Form_Profile($this->view->user);
        if(count($_POST) > 0 && $profileForm->isValid($_POST)){
            $values = $profileForm->getValues();
            $update = array();
            $update['ID'] = $this->view->user->ID;
            $update['Email'] = $values['email'];
            $this->view->user->Email = $values['email'];
            if($values['password']){
                $update['Password'] = $values['password'];
                $this->view->user->Password = $values['Password'];
            }
            $this->_database->updateUser($update);

            $this->view->success = 'Modifiche apportate con successo!';
        }
        $this->view->profileForm = $profileForm;
    }


}