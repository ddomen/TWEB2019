<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    protected $_logger;
    protected $_view;
    protected $_layout;
    protected $_db;
    protected $_dbcontext;
	protected $_loader;
        
        
    // Inizializzazione FrontController
    protected function _initRequest() {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }

    // Inizializzazione View
    protected function _initViewSettings() {
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        $this->_view->headMeta()->setCharset('UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
	    $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/fontawesome.min.css'));
	    $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/bootstrap.min.css'));
	    $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/style.css'));
        $this->_view->headScript()->appendFile($this->_view->baseUrl('js/jquery.js'));
        $this->_view->headScript()->appendFile($this->_view->baseUrl('js/bootstrap.min.js'));
        $this->_view->headTitle('Noleggio Macchine');

        global $APP_CONFIGURATION;
        $this->_view->app = new stdClass;
        foreach($APP_CONFIGURATION as $key=>$config){ $this->_view->app->{$key} = $config; }

    }

    // Inizializzazione Layout
    protected function _initLayoutSettings(){
        $this->bootstrap('layout');
        $this->_layout = $this->getResource('layout');
    }

    // Inizializzazione AutoLoader
    protected function _initDefaultModuleAutoloader() {
    	$this->_loader = Zend_Loader_Autoloader::getInstance();
		$this->_loader->registerNamespace('App_');
        $this->getResourceLoader()
             ->addResourceType('modelResource','models/resources','Resource');  
    }

    // Inizializzazione del database
    protected function _initDbParms() {
    	include_once (APPLICATION_PATH . '/../../include/connect.php');
		$this->_db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => $HOST,
            'username' => $USER,
            'password' => $PASSWORD,
            'dbname'   => $DB
        ));
		Zend_Db_Table_Abstract::setDefaultAdapter($this->_db);
        $this->_dbcontext = Application_Model_DBContext::Instance();
    }

    
    // Inizializzazione dei ruoli
    protected function _initRoles(){
        $acl = new Zend_Acl();
        $this->_view->acl = $acl;
        $roles = $this->_dbcontext->getRoles();

        $lastRole = new Zend_Acl_Role($roles[0]->Nome);
        $acl->addRole($lastRole);
        $acl->allow($roles[0]->Nome, null, array(strval($roles[0]->Livello), $roles[0]->Nome));

        for($i = 1; $i < count($roles); $i++){
            $role = new Zend_Acl_Role($roles[$i]->Nome);
            $acl->addRole($role, $lastRole);
            $acl->allow($roles[$i]->Nome, null, array(strval($roles[$i]->Livello), $roles[$i]->Nome));
            $lastRole = $role;
        }

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $faq=$auth->getIdentity();
            
            $occ = $this->_dbcontext->getOccupazioni()->toArray();
            foreach($occ as $o){ if($user->Occupazione == $o['ID']){ $user->OccupazioneNome = $o['Nome']; break; } }
            
            $this->_view->user = $user;
            $this->_view->faq = $faq;
            $this->_view->currentRole = $roles[$this->_view->user->Ruolo - 1]->Nome;
            $this->_view->currentRoleLevel = $roles[$this->_view->user->Ruolo - 1]->Livello;
        }
    }
}

