<?php

class PublicController extends Zend_Controller_Action
{
    protected $_database;
    protected $_redirector;
    
    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->view->layout = 'public';
    }

    public function indexAction() {
        if($this->view->currentRoleLevel > 1){ $this->_redirector->gotoSimple('index', 'user'); }
        $this->view->assign(array('topFaqs' => $this->_database->getTopFaq()));
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
        $loginForm = new App_Form_Login();
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

    public function catalogAction(){ $this->view->assign(array('catalog' => $this->_database->getCatalog())); }

    public function signinAction(){}
    public function aboutusAction(){}
    public function contactsAction(){}
    public function rulesAction(){}
    public function faqAction(){}

}