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
    public function adminfaqvalidationAction(){
        $this->_checkAccessRole('Admin');
        $fform = new Application_Form_Admin_Faq_Add();
        $response = $fform->processAjax($_POST); 
        if ($response !== null) { $this->_send($response); }
    }
}