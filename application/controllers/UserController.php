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
    public function faqAction(){
        $this->view->assign(array('allFaqs' => $this->_database->getFaqs()));
        $this->_helper->viewRenderer->renderBySpec('faq', array('controller' => 'public'));
    }


    public function catalogAction(){
        $paged = $this->_getParam('page', 1);
        $ordinator=$this->_getParam('orderBy',null);

        $form = new Application_Form_Public_Macchine_Filter();
        
        if (!$form->isValid($_POST)) { return $this->render('catalog'); }
        
        $values = $form->getValues();
        
        $this->view->assign(array(
            'catalog' => $this->_database->getCatalog($values, $ordinator, $paged),
            'catalogForm' => $form,
            'bottoneNoleggio' => '<input type="button" class="btn btn-primary noleggia" value="NOLEGGIA" style="font-size: 2em">',
            'pannelloNoleggio' => ''
        ));
        $this->_helper->viewRenderer->renderBySpec('catalog', array('controller' => 'public'));
    }

    public function profileAction(){
        $profileForm = new Application_Form_Public_Utenti_Profile($this->view->user);
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


}