<?php
class Application_Form_User_Macchine_Filter extends Application_Form_Abstract
{
	public function init() {
		$this->setMethod('post');
		$this->setName('filtercar');
		$this->setAction('');
                
                
            $this->addElement('text', 'modello', array(
                  'label' => 'Modello',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                  'decorators' => $this->elementDecorators,
                  'autofocus' => true
		));          
            
            $this->addElement('text', 'marca', array(
                  'label' => 'Marca',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                'decorators' => $this->elementDecorators,
		)); 
            
            $this->addElement('text', 'prezzoMin', array(
                  'label' => 'Prezzo Minimo',
                  'filters' => array('LocalizedToNormalized'),
                  'validators' => array(array('Float', true, array('locale' => 'en_US'))),
                'decorators' => $this->elementDecorators,
                'class' => 'validation number'
		));
            
            $this->addElement('text', 'prezzoMax', array(
                  'label' => 'Prezzo Massimo',
                  'filters' => array('LocalizedToNormalized'),
                  'validators' => array(array('Float', true, array('locale' => 'en_US'))),
                'decorators' => $this->elementDecorators,
                'class' => 'validation number'
		));
            
            $this->addElement('text', 'posti', array(
                  'label' => 'Posti',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                'decorators' => $this->elementDecorators,
                'class' => 'validation integer'
		));
            
            $this->addElement('text', 'allestimento', array(
                  'label' => 'Allestimento',
                  'filters' => array('StringTrim'),
                  'description' => 'Inserire allestimento e caratteristiche della macchina',
                  'validators' => array(array('StringLength', true, array(1,25))),
                  'decorators' => $this->elementDecorators,
		)); 

            $this->addElement('text', 'from', array(
                  'label' => 'Da: ',
                  'filters' => array('StringTrim'),
                  'decorators' => $this->elementDecorators,
                  'validators' => array(array('regex', false, array('/^\d\d[\-\/]\d\d[-\/]\d\d\d\d$/'))),
                  'class' => 'validation date'
            ));

            $this->addElement('text', 'to', array(
                  'label' => 'A: ',
                  'filters' => array('StringTrim'),
                  'decorators' => $this->elementDecorators,
                  'validators' => array(array('regex', false, array('/^\d\d[\-\/]\d\d[-\/]\d\d\d\d$/'))),
                  'class' => 'validation date'
            ));
            
            $this->addElement('select', 'OrderBy', array('label'=>'Ordina per: ',
                'multiOptions' => array('ASC_P' => 'Prezzo: crescente', 
                                        'DESC_P' => 'Prezzo: decrescente',
                                        'ASC_S' => 'Posti: crescente', 
                                        'DESC_S' => 'Posti: decrescente'),
                'decorators' => $this->elementDecorators
                    ));
            
            


            $this->addElement('submit', 'search', array('label' => 'RICERCA', 'decorators' => $this->buttonDecorators));
            
            $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
			'Form'
		));
            
            
            
        }
    
    
}