<?php
class Application_Form_Admin_Faq_Modify extends App_Form_Abstract
{
    
        protected $_adminModel;
        
        public function __construct($faq) {
            $this->faq=$faq;
            parent::__construct();
        }
    
	public function init(){
                $this->_adminModel = new Application_Model_Admin();
		$this->setMethod('post');
		$this->setName('modifyfaq');
		$this->setAction('');
                
            
                
               
            $this->addElement('text', 'titolo', array(
                  'label' => 'Modifica domanda',
                  'required' => false,
                'value' => 'ciao',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,10000))),
                'decorators' => $this->elementDecorators,
		));    
            $this->addElement('text', 'testo', array(
                  'label' => 'Modifica risposta',
                  'required' => false,
                //value' => $this->faq->Testo,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,10000))),
                'decorators' => $this->elementDecorators,
		));
            $this->addElement('text', 'punteggio', array(
                  'label' => 'Modifica punteggio',
                  'required' => false,
                //'value' => $this->faq->Punteggio,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,10000))),
                'decorators' => $this->elementDecorators,
		));
            
             
          
            $this->addElement('submit', 'Modifica', array('label' => 'MODIFICA',
                                                        'decorators' => $this->buttonDecorators
                ));
            
            $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
			'Form'
		));
        }
}