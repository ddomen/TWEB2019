<?php	
 class ErrorController extends Zend_Controller_Action {
    public function indexAction(){
        $this->_helper->layout->setLayout('error');
        $this->_helper->viewRenderer('error');
        $this->view->message = 'Errore sconosciuto';
    }

    public function authAction(){
        $this->_helper->layout->setLayout('error');
        $this->_helper->viewRenderer('error');
        $this->view->message = 'Accesso negato';
    }

    public function errorAction() {	
        $this->_helper->layout->setLayout('error');
        $errors = $this->_getParam('error_handler');	
        $this->view->error = $errors;
        	
        if (!$errors || !$errors instanceof ArrayObject) {	
            $this->view->message = 'Errore sconosciuto';	
            return;	
        }	
        	
        switch ($errors->type) {	
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:	
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:	
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:	
                // 404 error -- controller or action not found	
                $this->getResponse()->setHttpResponseCode(404);	
                $priority = Zend_Log::NOTICE;	
                $this->view->message = 'Pagina non trovata';	
                break;	
            default:	
                // application error	
                $this->getResponse()->setHttpResponseCode(500);	
                $priority = Zend_Log::CRIT;	
                $this->view->message = 'Errore dell\'Applicazione';	
                break;	
        }	
        	
        // Log exception, if logger available	
        if ($log = $this->getLog()) {	
            $log->log($this->view->message, $priority, $errors->exception);	
            $log->log('Request Parameters', $priority, $errors->request->getParams());	
        }	
        	
        // conditionally display exceptions	
        if ($this->getInvokeArg('displayExceptions') == true) {	
            $this->view->exception = $errors->exception;	
        }	
        	
        $this->view->request   = $errors->request;	
    }	
     public function getLog()	
    {	
        $bootstrap = $this->getInvokeArg('bootstrap');	
        if (!$bootstrap->hasResource('Log')) {	
            return false;	
        }	
        $log = $bootstrap->getResource('Log');	
        return $log;	
    }	
}