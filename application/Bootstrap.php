<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    protected $_view;
    protected $_layout;

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
	    $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/style.css'));
        $this->_view->headScript()->appendFile($this->_view->baseUrl('js/jquery.js'));
        $this->_view->headTitle('Noleggio Macchine');
    }

    // Inizializzazione Layout
    protected function _initLayoutSettings(){
        $this->bootstrap('layout');
        $this->_layout = $this->getResource('layout');
    }
}

