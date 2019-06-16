<?php

class StaffController extends Zend_Controller_Action
{

    protected $_database;
    protected $_redirector;
    protected $_form;
    protected $_addForm;
    protected $_editForm;

    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        if(!$this->view->acl->isAllowed($this->view->currentRole, null, 'Staff')){ $this->_redirector->gotoSimple('auth', 'error'); }

        $this->view->headScript()->appendFile($this->view->baseUrl('js/client.messanger.js'));
        $this->view->layout = 'staff';
        $this->view->macchinaForm = $this->getMacchinaForm();
       
    }

    public function indexAction() {
        if($this->view->currentRoleLevel >= 3){ $this->_redirector->gotoSimple('index', 'admin'); }
        $this->view->assign(array('topFaqs' => $this->_database->getTopFaq()));
        $this->_helper->viewRenderer->renderBySpec('index', array('controller' => 'public'));
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
                array_push($list, $prs[$i]);
            }
            $this->view->assign(array('noleggiList' => $list));
        }
    }
     



    public function aboutusAction(){ $this->_helper->viewRenderer->renderBySpec('aboutus', array('controller' => 'public')); }
    public function contactsAction(){ $this->_helper->viewRenderer->renderBySpec('contacts', array('controller' => 'public')); }
    public function rulesAction(){ $this->_helper->viewRenderer->renderBySpec('rules', array('controller' => 'public')); }
    public function faqAction(){
        $this->view->assign(array('allFaqs' => $this->_database->getFaqs()));
        $this->_helper->viewRenderer->renderBySpec('faq', array('controller' => 'public'));
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

//INIZIO METODI AGGIUNTA MACCHINA-------------------------------------------------------------
public function newmacchinaAction()
	{}

	public function addmacchinaAction()
	{
		if (!$this->getRequest()->isPost()) {
			$this->_redirector->goToSimple('catalog', 'staff');
		}
		$form=$this->_addForm;
		if (!$form->isValid($_POST)) {
			return $this->render('newmacchina');
		}
		$values = $form->getValues();
		$this->_database->saveCar($values);
		$this->_redirector->goToSimple('catalog', 'staff');
	}

	private function getMacchinaForm()
	{
		$urlHelper = $this->_helper->getHelper('url');
		$this->_addForm = new Application_Form_Staff_Macchine_Add();
		$this->_addForm->setAction($urlHelper->url(array(
				'controller' => 'staff',
				'action' => 'addmacchina'),
				'default'
				));
		return $this->_addForm;
	}

//FINE METODI AGGIUNTA MACCHINA--------------------------------------------------------------


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