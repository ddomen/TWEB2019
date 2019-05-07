<?php

class FaqController extends Zend_Controller_Action {
    protected $_catalogModel;

    public function init() {
        $this->_catalogModel = new Application_Model_Catalog();
    }

    public function indexAction() {
        $topFaqs = $this->_catalogModel->getTopFaqs();

        $this->view->assign(array( 'topFaqs' => $topFaqs ));
    }


}

