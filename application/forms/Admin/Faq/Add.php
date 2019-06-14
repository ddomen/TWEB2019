<?php
class Application_Form_Admin_Faq_Add extends Application_Form_Abstract
{
    
	public function init(){
		$this->setMethod('post');
		$this->setName('addfaq');
		$this->setAction('');
                
                
            $this->addElement('textarea', 'titolo', array(
                  'label' => 'Domanda',
                  'required' => true,
                  'cols' => '120', 
                  'rows' => '3',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', false, array(1,150))),
                'decorators' => $this->elementDecorators,
		));    
            $this->addElement('textarea', 'testo', array(
                  'label' => 'Risposta',
                  'required' => true,
                  'cols' => '120', 
                  'rows' => '3',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', false, array(1,150))),
                'decorators' => $this->elementDecorators,
		));
            $this->addElement('text', 'punteggio', array(
                  'label' => 'Punteggio',
                  'required' => true,
                  'filters' => array('LocalizedToNormalized'),
                  'validators' => array(array('int', true, array('locale' => 'en_US'))),
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