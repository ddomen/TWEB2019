<?php

class ApiController extends Zend_Controller_Action
{
    protected $_database;
    protected $_redirector;
    protected $_response;
    protected $_sent;

    protected function _checkAccessRole($role){
        if(!$this->view->acl->isAllowed($this->view->currentRole, null, $role)){
            $error = new stdClass;
            $error->ok = false;
            $error->message = "unauthorized";
            $error->code = "401";
            $this->_send($error, 401, true);
        }
    }

    protected function _send($response, $code = 200, $force = false){
        if(!$this->_sent || $force){
            $this->_response
                    ->setHeader('Content-type','application/json')
                    ->setHttpResponseCode($code)
                    ->setBody(is_string($response) ? $response :json_encode($response));
            $this->_sent = true;
        }
        return $this;
    }

    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
        $this->_response = $this->getResponse();
    }
    
    public function indexAction(){
        $this->_send(array('0' => 'ciao'));
    }

    // Validazione form di inserimento faq con AJAX
    public function newfaqvalidationAction(){
        $this->_checkAccessRole('Admin');
        $form = new Application_Form_Admin_Faq_Add();
        $response = $form->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }
    
    // Validazione form di modifica faq con AJAX
    public function editfaqvalidationAction(){
        $this->_checkAccessRole('Admin');
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
        $response = $editForm2->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }
    
    // Validazione form di inserimento macchina con AJAX
    public function newcarvalidationAction(){
        $this->_checkAccessRole('Staff');
        $form = new Application_Form_Staff_Macchine_Add();
        $response = $form->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }

    // Validazione form di modifica macchina con AJAX
    public function editcarvalidationAction(){
        $this->_checkAccessRole('Staff');
        $carid = intval($this->_getParam('id', 0));
        $car = $this->_database->getCarById($carid);
        $this->view->editMacchina = $car;
         $_editForm = new Application_Form_Staff_Macchine_Modify($car);
        $response = $_editForm->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }      
    
    // Validazione form di registrazione utente con AJAX
    public function signinvalidationAction(){
        $occ = $this->_database->getOccupazioni();
        $occupazioni = array();
        foreach($occ as $o){ $occupazioni[$o->ID] = $o->Nome; }
        $signinForm = new Application_Form_Public_Utenti_Signin($occupazioni);
        $response = $signinForm->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }
    
    // Validazione form di login con AJAX
    public function loginvalidationAction(){
        $form = new Application_Form_Public_Utenti_Login();
        $response = $form->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }  
    
    // Validazione form di inserimento di un utente con AJAX
    public function newuservalidationAction(){
        $this->_checkAccessRole('Admin');
        $occ = $this->_database->getOccupazioni();
        $occupazioni = array();
        foreach($occ as $o){ $occupazioni[$o->ID] = $o->Nome; }
        $form = new Application_Form_Public_Utenti_Signin($occupazioni);
        $response = $form->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }
    
    
    
    // Validazione form di modifica utente da parte dell'utente con AJAX
    public function useredituservalidationAction(){
        $this->_checkAccessRole('Utente');
        $profileForm = new Application_Form_User_Utenti_Profile($this->view->user);
        $response = $profileForm->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }
    
    
    // Validazione form di modifica utente da parte dell'admin con AJAX
    public function edituservalidationAction(){
        $this->_checkAccessRole('Admin');
        
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
        }
        $response = $editForm->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }   

    public function checknoleggioAction(){
        $this->_checkAccessRole('Utente');

        $inizio = strtotime($_POST['inizio']);
        $fine = strtotime($_POST['fine']);
        if($inizio > $fine){ $this->_send(array('testo' => 'Range di date invalido!', 'tipo' => 'danger')); }
        else{
            $macchina = intval($_POST['macchina']);
    
            if($this->_database->checkNoleggio($macchina, date('Y-m-d', $inizio), date('Y-m-d', $fine))){
                $this->_send(array('testo' => 'Date disponibili!', 'tipo' => 'success'));
            }
            else{
                $this->_send(array('testo' => 'Date non disponibili!', 'tipo' => 'danger'));
            }
        }
    }

    public function sendmessageAction(){
        $this->_checkAccessRole('Utente');
        $isUser = $this->view->currentRole != 'Admin';
        
        $testo = strval($_POST['testo']);
        if($isUser){
            $destinatari = $this->_database->getAdministrators();
            foreach($destinatari as $destinatario){
                $this->_database->insertMessage(array(
                    'Mittente' => $this->view->user->ID,
                    'Destinatario' => $destinatario->ID,
                    'Testo' => $testo,
                    'Data' => date('Y-m-d H:i:s')
                ));
            }
        }
        else{
            $destinatario = $_POST['destinatario'];
            $this->_database->insertMessage(array(
                'Mittente' => $this->view->user->ID,
                'Destinatario' => $destinatario,
                'Testo' => $testo,
                'Data' => date('Y-m-d H:i:s')
            ));
        }
        $this->_send(array('ok' => true));
    }

    public function checkmessagesAction(){
        $this->_checkAccessRole('Utente');
        $messages = $this->_database->getMessagesByUser($this->view->user->ID)->toArray();
        $_users = $this->_database->getAllUsers();
        $users = array();
        foreach($_users as $u){ $users[$u->ID] = $u->Username; }

        for($i = 0; $i < count($messages); $i++){
            $messages[$i]['Inviato'] = $messages[$i]['Mittente'] == $this->view->user->ID;
            $dest = $messages[$i]['Inviato'] ? 'Destinatario' : 'Mittente';
            $messages[$i]['Utente'] = $users[$messages[$i][$dest]];
        }
        $this->_send($messages);
    }

    public function catalogAction(){
        if($this->view->currentRole == 'Pubblico'){ unset($_POST['from']); unset($_POST['to']); }
        $this->_send($this->_database->getCatalogApi($_POST));
    }
}