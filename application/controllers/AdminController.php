<?php

class AdminController extends Zend_Controller_Action
{
    protected $_database;
    protected $_redirector;
    
    protected $_form;

    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        if(!$this->view->acl->isAllowed($this->view->currentRole, null, 'Admin')){
            $this->_redirector->gotoSimple('auth', 'error');    
        }
        $this->view->headScript()->appendFile($this->view->baseUrl('js/admin.messanger.js'));
        $this->view->layout = 'admin';
        $this->view->faqForm = $this->getFaqForm();
        
        

    }
    
    public function indexAction() {
        $this->view->mesi = array(null, 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
        $this->view->prospettoMese = $this->_database->getProspettoMensile();
        $this->view->prospettoAnno = $this->_database->getProspettoANno();
    }
    
    
    public function aboutusAction(){ $this->_helper->viewRenderer->renderBySpec('aboutus', array('controller' => 'public')); }
    public function contactsAction(){ $this->_helper->viewRenderer->renderBySpec('contacts', array('controller' => 'public')); }
    public function rulesAction(){ $this->_helper->viewRenderer->renderBySpec('rules', array('controller' => 'public')); }
    public function faqAction(){
        $this->view->assign(array('allFaqs' => $this->_database->getFaqs()));
    }
    

    public function newfaqAction(){
        
    }
   
    public function addfaqAction()
	{
		if (!$this->getRequest()->isPost()) {
			$this->_redirector->goToSimple('faq', 'admin');
		}
		$form=$this->_form;
		if (!$form->isValid($_POST)) {
			return $this->render('newfaq');
		}
		$values = $form->getValues();
		$this->_database->saveFaq($values);
        $this->_redirector->goToSimple('faq', 'admin');
	}
    private function getFaqForm()
	{
		$urlHelper = $this->_helper->getHelper('url');
		$this->_form = new Application_Form_Admin_Faq_Add();
		$this->_form->setAction($urlHelper->url(array(
				'controller' => 'admin',
				'action' => 'addfaq'),
				'default'
				));
		return $this->_form;
	}
    
    public function editfaqAction(){
        $faqID = intval($this->_getParam('id', 0));
        $faq = $this->_database->getFaqById($faqID);

        if($faq == null){ $this->view->error = 'Faq non trovata'; }
        else{
            $this->view->editFaq = $faq;
            $editForm2 = new Application_Form_Admin_Faq_Edit($faq);

            if(count($_POST) > 0 && $editForm2->isValid($_POST)){
                $values = $editForm2->getValues();
                $values['ID'] = $faq->ID;
                $this->_database->updateFaq($values);
                $this->_redirector->goToSimple('faq', 'admin');
            }
            $this->view->editForm2= $editForm2;
        }
    }   
        
    public function deletefaqAction(){
        $faqid = intval($this->_getParam('id', 0));
        $faq = $this->_database->getFaqById($faqid);

        if($faq == null){ $this->view->error = 'Faq non trovata'; }
        else{
            $this->_database->deleteFaq($faq['ID']);
            $this->_redirector->goToSimple('faq', 'admin');
        }
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
        $this->_helper->viewRenderer->renderBySpec('profile', array('controller' => 'user'));
    }

    public function catalogAction(){ $this->_helper->viewRenderer->renderBySpec('catalog', array('controller' => 'public')); }

    

    public function usersAction(){
        $this->view->users = $this->_database->getAllUsers()->toArray();
        $roles = $this->_database->getRoles()->toArray();
        $works = $this->_database->getOccupazioni()->toArray();

        for($i = 0; $i < count($this->view->users); $i++){
            $this->view->users[$i]['RuoloTesto'] = $roles[$this->view->users[$i]['Ruolo'] - 1]['Nome'];
            $this->view->users[$i]['OccupazioneTesto'] = $works[$this->view->users[$i]['Occupazione'] - 1]['Nome'];
        }
    }

    public function edituserAction(){
        $userid = intval($this->_getParam('id', 0));
        $user = $this->_database->getUserById($userid);

        if($user == null){ $this->view->error = 'Utente non trovato'; }
        else{
            $occ = $this->_database->getOccupazioni();
            $occupazioni = array();
            foreach($occ as $o){ $occupazioni[$o->ID] = $o->Nome; }

            $roleNames = array();
            foreach($this->view->allRoles as $role){ if($role->Livello > 0){ $roleNames[$role->ID] = $role->Nome; } }

            $this->view->editUser = $user;
            $editForm = new Application_Form_Admin_Utenti_Modify($occupazioni, $roleNames, $user);

            if(count($_POST) > 0 && $editForm->isValid($_POST)){
                $values = $editForm->getValues();
                
                $values['nascita'] = preg_replace('/(\d\d)[-\/](\d\d)[-\/](\d\d\d\d)/', '$3-$2-$1', $values['nascita']);
                $values['ID'] = $user->ID;
                $this->_database->updateUser($values);
                $this->_redirector->goToSimple('users', 'admin');
            }

            $this->view->editForm = $editForm;
        }

    }
    
    public function createuserAction(){
        $occ = $this->_database->getOccupazioni();
        $occupazioni = array();
        foreach($occ as $o){ $occupazioni[$o->ID] = $o->Nome; }

        $roleNames = array();
        foreach($this->view->allRoles as $role){ if($role->Livello > 0){ $roleNames[$role->ID] = $role->Nome; } }

        $createForm = new Application_Form_Public_Utenti_Signin($occupazioni, false, $roleNames);

        if(count($_POST) > 0 && $createForm->isValid($_POST)){
            $values = $createForm->getValues();
            $usr = $this->_database->getUserByUsername($values['username']);
            if($usr == null){
                $values['nascita'] = preg_replace('/(\d\d)[-\/](\d\d)[-\/](\d\d\d\d)/', '$3-$2-$1', $values['nascita']);
                $this->_database->insertUser($values);
                $this->_redirector->gotoSimple('users', 'admin');
            }
            else{ $this->view->error = 'Nome utente già in uso'; }
        }

        $this->view->createForm = $createForm;

    }

    public function deleteuserAction(){
        $userid = intval($this->_getParam('id', 0));
        $user = $this->_database->getUserById($userid);

        if($user == null){ $this->view->error = 'Utente non trovato'; }
        else if($user['ID'] == $this->view->user->ID){ $this->view->error = 'Impossibile cancellare il proprio utente'; }
        else{
            $this->_database->deleteUser($user['ID']);
            $this->_redirector->goToSimple('users', 'admin');
        }
    }
    
    
    public function editmacchinaAction(){
        $carid = intval($this->_getParam('id', 0));
        $car = $this->_database->getCarById($carid);

        if($car == null){ $this->view->error = 'Macchina non trovata'; }
        else{
            $this->view->editMacchina = $car;
         $_editForm = new Application_Form_Staff_Macchine_Modify($car);
            if(count($_POST) > 0 && $_editForm->isValid($_POST)){
                $values = $_editForm->getValues();
                $values['ID'] = $car->ID;
                if(!$values['foto']){ unset($values['foto']); }
                $this->_database->updateCar($values);
                $this->_redirector->goToSimple('catalog', 'staff');
            }

            $this->view->editForm = $_editForm;
        }
        $this->_helper->viewRenderer->renderBySpec('editmacchina', array('controller' => 'staff'));
    }
    
    
    
    public function deletemacchinaAction(){ 
        $carid = intval($this->_getParam('id', 0)); //recupero l'id della macchina
        $car = $this->_database->getCarById($carid);

        if($car == null){ $this->view->error = 'Macchina non trovata'; }
        else{
            $this->_database->deleteCar($car['ID']);
            $this->_redirector->goToSimple('catalog', 'admin');
        }
    }

    public function noleggiAction(){
        $month=$this->_getParam('m', null);
        if($month==''){ $this->view->error = 'Nessun mese selezionato'; }
        else{
            $prs = $this->_database->getMonth(strtolower($month));
            $list = array();
            for($i = 0; $i < count($prs); $i++){
                if(!$prs[$i]->Marca){ $prs[$i]->Marca = 'MACCHINA ELMINATA'; }
                if(!$prs[$i]->TARGA){ $prs[$i]->TARGA = 'MACCHINA ELMINATA'; }
                if(!$prs[$i]->Nome){ $prs[$i]->TARGA = 'UTENTE ELMINATO'; }
                if(!$prs[$i]->Cognome){ $prs[$i]->TARGA = 'UTENTE ELMINATO'; }
                array_push($list, $prs[$i]);
            }
            $this->view->assign(array('noleggiList' => $list));
        }
        $this->_helper->viewRenderer->renderBySpec('noleggi', array('controller' => 'staff'));
    }
}
    
    
    
