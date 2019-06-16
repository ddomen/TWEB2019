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

        $this->view->headScript()->appendFile($this->view->baseUrl('js/client.messanger.js'));
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
    public function faqAction(){
        $this->view->assign(array('allFaqs' => $this->_database->getFaqs()));
        $this->_helper->viewRenderer->renderBySpec('faq', array('controller' => 'public'));
    }


    public function catalogAction(){
        $paged = $this->_getParam('page', 1);

        $form = new Application_Form_User_Macchine_Filter();
        
        if ($form->isValid($_POST)) { $values = $form->getValues(); }
        $this->view->assign(array(
            'catalog' => $this->_database->getCatalog($values, $paged),
            'catalogForm' => $form
        ));
        
        $this->_helper->viewRenderer->renderBySpec('catalog', array('controller' => 'public'));
    }

    public function profileAction(){
        $this->view->noleggiList = $this->_database->getNoleggiStoricoUtente($this->view->user->ID);

        $profileForm = new Application_Form_User_Utenti_Profile($this->view->user);
        if(count($_POST) > 0 && $profileForm->isValid($_POST)){
            $values = $profileForm->getValues();
            $update = array();
            $update['ID'] = $this->view->user->ID;
            $update['Email'] = $values['email'];
            $this->view->user->Email = $values['email'];
            if($values['password']){
                $update['Password'] = $values['password'];
                $this->view->user->Password = $values['password'];
            }
            $this->_database->updateUser($update);

            $this->view->success = 'Modifiche apportate con successo!';
        }
        $this->view->profileForm = $profileForm;
    }

    public function noleggiaAction(){
        $macchina = $this->_getParam('id', null);
        $from = $this->_getParam('from', null);
        $to = $this->_getParam('to', null);

        
        if(!$macchina || !$from || !$to){ $this->view->error = 'Impossibile prenotare l\'auto!'; }
        else{
            $from = strtotime($from);
            $to = strtotime($to);
            $now = time();
            if(!$from || !$to || $from < $now || $to < $now){ $this->view->error = 'Range di date invalido!'; }
            else{
                $car = $this->_database->getCarById($macchina);
                if($car == null){ $this->view->error = 'Macchina da prenotare non trovata!'; }
                else{
                    $this->view->car = $car;
                    $from = date('Y-m-d', $from);
                    $to = date('Y-m-d', $to);
                    if($this->_database->checkNoleggio($macchina, $from, $to)){
                        $noleggio = array('Macchina' => $macchina, 'Noleggiatore' => $this->view->user->ID, 'Inizio' => $from, 'Fine' => $to);
                        $this->_database->insertNoleggio($noleggio);
                        $this->view->noleggio = $noleggio;
                    }
                    else{
                        $this->view->error = 'Macchina occupata nel range di date!';
                    }
                }
            }
        }

    }


}