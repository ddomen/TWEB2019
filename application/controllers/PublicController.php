<?php

class PublicController extends Zend_Controller_Action
{

    protected $_catalogModel;

    public function init() {

        /* Initialize action controller here */
        $this->view->headScript()->appendFile($this->view->baseUrl('js/messanger.js'));
        $this->_helper->layout->setLayout('public');

    }

    public function indexAction() {
        // action body
    }
    
    public function aboutusAction(){
           
    }
          
    public function contattaciAction(){
        
    }


    public function catalogAction(){




    }

}