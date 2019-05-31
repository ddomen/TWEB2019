<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    protected $_logger;
    protected $_view;
    protected $_layout;
    protected $_db;
	protected $_loader;

    // Inizializzazione del Log
    // protected function _initLogging() {
    //     $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/data/log/logFile.log');        
    //     $logger = new Zend_Log($writer);

    //     Zend_Registry::set('log', $logger);

    //     $this->_logger = $logger;
   	//     $this->_logger->info('Bootstrap Inizializzazione Log');
    // }

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
    }
}

