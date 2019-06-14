<?php

class StaffController extends Zend_Controller_Action
{

    protected $_database;
    protected $_redirector;
    protected $_form;

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

    public function noleggiAction(){
        $month=$this->_getParam('m',null);
        $this->view->assign(array('noleggiList' => $this->_database->getMonth(strtolower($month))));
    } 



    public function insertAction(){
        //action che richiama la view per l'inserimento di una macchina
    }

    public function aboutusAction(){ $this->_helper->viewRenderer->renderBySpec('aboutus', array('controller' => 'public')); }
    public function contactsAction(){ $this->_helper->viewRenderer->renderBySpec('contacts', array('controller' => 'public')); }
    public function rulesAction(){ $this->_helper->viewRenderer->renderBySpec('rules', array('controller' => 'public')); }
    public function faqAction(){
        $this->view->assign(array('allFaqs' => $this->_database->getFaqs()));
        $this->_helper->viewRenderer->renderBySpec('faq', array('controller' => 'public'));
    }
    
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
        $this->_helper->viewRenderer->renderBySpec('profile', array('controller' => 'user'));
    }

    public function catalogAction(){
        $paged = $this->_getParam('page', 1);
        $ordinator=$this->_getParam('orderBy',null);

        $form = new App_Form_Catalogfilter();
        
        if (!$form->isValid($_POST)) { return $this->render('catalog'); }
        
        $values = $form->getValues();
        
        $this->view->assign(array(
            'catalog' => $this->_database->getCatalog($values, $ordinator, $paged),
            'catalogForm' => $form,
            'bottoneModifica' => '<input type="button" class="btn btn-primary" value="MODIFICA" style="font-size: 2em">',
            'bottoneElimina' => '<input type="button" class="btn btn-danger" value="ELIMINA" style="font-size: 2em">',
            'pannelloNoleggio' => '<input type="button" class="btn btn-success" value="AGGIUNGI" style="font-size: 2em">'
        ));
        $this->_helper->viewRenderer->renderBySpec('catalog', array('controller' => 'public'));
    }

    public function editmacchinaAction(){
        //todo

    }

    public function deletemacchinaAction(){ 
    $carid = intval($this->_getParam('id', 0)); //recupero l'id della macchina
        $car = $this->_database->getCarById($carid);

        if($car == null){ $this->view->error = 'Macchina non trovata'; }
        else{
            $this->_database->deleteCar($car['ID']);
            $this->_redirector->goToSimple('catalog', 'staff');
        }
    }


    

}