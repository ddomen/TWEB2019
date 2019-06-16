<?php
class Application_Form_Staff_Macchine_Add extends Application_Form_Abstract
{
    
	public function init(){
		$this->setMethod('post');
		$this->setName('addmacchina');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
                
                
            $this->addElement('text', 'targa', array(
                  'label' => 'Targa',
                  'required' => true,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', false, array(1,150))),
                'decorators' => $this->elementDecorators,
		));    
            $this->addElement('text', 'marca', array(
                  'label' => 'Marca',
                  'required' => true,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', false, array(1,150))),
                'decorators' => $this->elementDecorators,
        ));
            $this->addElement('text', 'modello', array(
                  'label' => 'Modello',
                  'required' => true,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', false, array(1,150))),
                'decorators' => $this->elementDecorators,
        ));
            $this->addElement('text', 'prezzo', array(
                  'label' => 'Prezzo',
                  'required' => true,
                  'filters' => array('LocalizedToNormalized'),
                  'validators' => array(array('float', true, array('locale' => 'en_US'))),
                'decorators' => $this->elementDecorators,
        ));
        
		$this->addElement('file', 'foto', array(
			'label' => 'Immagine',
			'destination' => APPLICATION_PATH . '/../public/images/vetture',
			'validators' => array( 
			array('Count', false, 1),
			array('Size', false, 102400),
			array('Extension', true, array('jpg', 'gif', 'png'))),
            ));

        $this->addElement('text', 'allestimento', array(
                  'label' => 'Allestimento',
                  'required' => true,
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', false, array(1,150))),
                'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'posti', array(
            'label' => 'Posti:',
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