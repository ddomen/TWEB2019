<?php

class AdminController extends Zend_Controller_Action
{
    protected $_database;
    protected $_redirector;
    
    protected $_adminModel;
    protected $_form;

    public function init() {
        $this->_database = Application_Model_DBContext::Instance();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        if(!$this->view->acl->isAllowed($this->view->currentRole, null, 'Admin')){
            $this->_redirector->gotoSimple('auth', 'error');    
        }

        $this->view->headScript()->appendFile($this->view->baseUrl('js/messanger.js'));
        $this->view->layout = 'admin';
        
        
        
        
        $this->_adminModel = new Application_Model_Admin();
	$this->view->faqForm = $this->getFaqForm();
        
    }

    public function indexAction() {
        $this->view->assign(array('topFaqs' => $this->_database->getTopFaq()));
        $this->_helper->viewRenderer->renderBySpec('index', array('controller' => 'public'));
    }

    public function aboutusAction(){ $this->_helper->viewRenderer->renderBySpec('aboutus', array('controller' => 'public')); }
    public function contactsAction(){ $this->_helper->viewRenderer->renderBySpec('contacts', array('controller' => 'public')); }
    public function rulesAction(){ $this->_helper->viewRenderer->renderBySpec('rules', array('controller' => 'public')); }
    public function faqAction(){
        $this->view->assign(array('allFaqs' => $this->_database->getFaqs()));
    }
    
    public function newfaqAction(){}
    
    public function addfaqAction()
	{
		if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('index');
		}
		$form=$this->_form;
		if (!$form->isValid($_POST)) {
			return $this->render('newfaq');
		}
		$values = $form->getValues();
		$this->_adminModel->saveFaq($values);
		$this->_helper->redirector('index');
	}
    private function getFaqForm()
	{
		$urlHelper = $this->_helper->getHelper('url');
		$this->_form = new Application_Form_Admin_Faq_Add();
		$this->_form->setAction($urlHelper->url(array(
				'controller' => 'admin',
				'action' => 'addfaq'),
				'default'
				));
		return $this->_form;
	}
        
        
    public function modificationfaqAction(){
    }    
        
    public function modifyfaqAction()
	{
		if (!$this->getRequest()->isPost()) {
			$this->_helper->redirector('index');
		}
		$form=$this->_form;
		if (!$form->isValid($_POST)) {
			return $this->render('modificationfaq');
		}
		$values = $form->getValues();
                $valID=$this->_getParam('ID',null);
                $faq= $this->getIDFaq($valID);
                $this->view->faqForm = $this->getFaqModifiedForm($faq);
		$this->_adminModel->saveModifyFaq($values,$valID);
		$this->_helper->redirector('index');
	}    
        
    private function getFaqModifiedForm($faq)
	{
		$urlHelper = $this->_helper->getHelper('url');
		$this->_form = new Application_Form_Admin_Faq_Modify($faq);
		$this->_form->setAction($urlHelper->url(array(
				'controller' => 'admin',
				'action' => 'modifyfaq'),
				'default'
				));
		return $this->_form;
	}   
    

    public function profileAction(){
        $profileForm = new App_Form_Profile($this->view->user);
        if(count($_POST) > 0 && $profileForm->isValid($_POST)){
            $values = $profileForm->getValues();
            $update = array();
            $update['ID'] = $this->view->user->ID;
            $update['Email'] = $values['email'];
            $this->view->user->Email = $values['email'];
            if($values['password']){
                $update['Password'] = $values['password'];
                $this->view->user->Password = $values['Password'];
            }
            $this->_database->updateUser($update);

            $this->view->success = 'Modifiche apportate con successo!';
        }
        $this->view->profileForm = $profileForm;
        $this->_helper->viewRenderer->renderBySpec('profile', array('controller' => 'user'));
    }

    public function catalogAction(){
        $paged = $this->_getParam('page', 1);
        $ordinator=$this->_getParam('orderBy',null);

        $form = new App_Form_CatalogFilter();
        
        if (!$form->isValid($_POST)) { return $this->render('catalog'); }
        
        $values = $form->getValues();
        
        $this->view->assign(array(
            'catalog' => $this->_database->getCatalog($values, $ordinator, $paged),
            'catalogForm' => $form,
            'bottoneNoleggio' => '<input type="button" class="btn btn-primary" value="MODIFICA" style="font-size: 2em">
                                    <input type="button" class="btn btn-danger" value="ELIMINA" style="font-size: 2em">',
            'pannelloNoleggio' => '<input type="button" class="btn btn-success" value="AGGIUNGI" style="font-size: 2em">'
        ));
        $this->_helper->viewRenderer->renderBySpec('catalog', array('controller' => 'public'));
    }
    

}