<?php
class Application_Form_Admin_Faq_Add extends App_Form_Abstract
{
    
        protected $_adminModel;
    
	public function init(){
                $this->_adminModel = new Application_Model_Admin();
		$this->setMethod('post');
		$this->setName('addfaq');
		$this->setAction('');
                
                
            $this->addElement('text', 'titolo', array(
                  'label' => 'Domanda',
                  'required' => true,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                'decorators' => $this->elementDecorators,
		));    
            $this->addElement('text', 'testo', array(
                  'label' => 'Risposta',
                  'required' => true,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                'decorators' => $this->elementDecorators,
		));
            $this->addElement('text', 'punteggio', array(
                  'label' => 'Punteggio',
                  'required' => true,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                'decorators' => $this->elementDecorators,
		));
            
             
          
            $this->addElement('submit', 'inserisci', array('label' => 'INSERISCI',
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