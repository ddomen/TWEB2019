<?php

class PublicController extends Zend_Controller_Action
{
    protected $_database;
    protected $_redirector;
    
    protected $_form;
    
    
    
    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->layout = 'public';
        
    }

    public function indexAction() {
        if($this->view->currentRoleLevel >= 1){ $this->_redirector->gotoSimple('index', 'user'); }
        $this->view->assign(array('topFaqs' => $this->_database->getTopFaq()));
        $form = new Application_Form_Public_Macchine_Filter();
        if (!$form->isValid($_POST)) { return $this->render('catalog'); }
        
        $values = $form->getValues();
        
        $this->view->assign(array(
            'catalog' => $this->_database->getCatalog($values, null, null),
            'catalogForm' => $form,
            'bottoneNoleggio' => '',
            'pannelloNoleggio' => '' 
        ));
    }

    protected function _getAuthAdapter(){
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('utenti')
                    ->setIdentityColumn('Username')
                    ->setCredentialColumn('Password');

        return $authAdapter;
    }

    protected function _login($values){
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);
        
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }

    protected function _logout(){
        Zend_Auth::getInstance()->clearIdentity();
        return true;

    }

    public function loginAction(){
        $loginForm = new Application_Form_Public_Utenti_Login();
        if(count($_POST) > 0 && $loginForm->isValid($_POST)){
            if($this->_login($loginForm->getValues())){ $this->_redirector->gotoSimple('index', 'user'); }
            else { $this->view->loginError = true; }
        }
        $this->view->loginForm = $loginForm;
    }

    public function logoutAction(){
        $this->_logout();
        $this->_redirector->gotoSimple('index', 'public');
    }

    public function catalogAction(){}

    public function signinAction(){
        $occ = $this->_database->getOccupazioni();
        $occupazioni = array();
        foreach($occ as $o){ $occupazioni[$o->ID] = $o->Nome; }

        $signinForm = new Application_Form_Public_Utenti_Signin($occupazioni);

        if(count($_POST) > 0 && $signinForm->isValid($_POST)){
            $values = $signinForm->getValues();
            $usr = $this->_database->getUserByUsername($values['username']);
            if(!$values['condizioni']){
                $this->view->error = 'Devi accettare i termini di utilizzo!';
            }
            else if($usr == null){
                $values['nascita'] = preg_replace('/(\d\d)[-\/](\d\d)[-\/](\d\d\d\d)/', '$3-$2-$1', $values['nascita']);
                $values['ruolo'] = 2;
                unset($values['condizioni']);
                $this->_database->insertUser($values);
                $this->_login($values);
                $this->_redirector->gotoSimple('index', 'user');
            }
            else{ $this->view->error = 'Nome utente già in uso'; }
        }
        $this->view->signinForm = $signinForm;
    }
    public function aboutusAction(){}
    public function contactsAction(){}
    public function rulesAction(){}
    public function faqAction(){ $this->view->assign(array('allFaqs' => $this->_database->getFaqs()));
    }    
            
}

