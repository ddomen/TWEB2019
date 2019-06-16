<?php
class Application_Form_Public_Macchine_Filter extends Application_Form_Abstract
{
	public function init() {
		$this->setMethod('post');
		$this->setName('filtercar');
		$this->setAction('');
                
                
            $this->addElement('text', 'modello', array(
                  'label' => 'Modello: ',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                  'decorators' => $this->elementDecorators,
                  'class' => 'form-control',
                  'autofocus' => true
		));          
            
            $this->addElement('text', 'marca', array(
                  'label' => 'Marca: ',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                  'class' => 'form-control',
                  'decorators' => $this->elementDecorators
		)); 
            
            $this->addElement('text', 'prezzoMin', array(
                  'label' => 'Prezzo Minimo: ',
                  'validators' => array(array('Float', true, array('locale' => 'en_US'))),
                  'decorators' => $this->elementDecorators,
                  'class' => 'form-control validation number'
		));
            
            $this->addElement('text', 'prezzoMax', array(
                  'label' => 'Prezzo Massimo: ',
                  'validators' => array(array('Float', true, array('locale' => 'en_US'))),
                  'decorators' => $this->elementDecorators,
                  'class' => 'form-control validation number'
		));
            
            $this->addElement('text', 'posti', array(
                  'label' => 'Posti: ',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
                  'decorators' => $this->elementDecorators,
                  'class' => 'form-control validation integer'
		));
            
            $this->addElement('text', 'allestimento', array(
                  'label' => 'Allestimento: ',
                  'filters' => array('StringTrim'),
                  'description' => 'Inserire allestimento e caratteristiche della macchina',
                  'validators' => array(array('StringLength', true, array(1,25))),
                  'decorators' => $this->elementDecorators,
                  'class' => 'form-control'
		)); 
            
            $this->addElement('select', 'OrderBy', array('label'=>'Ordina per: ',
                'multiOptions' => array('ASC_P' => 'Prezzo: crescente', 
                                        'DESC_P' => 'Prezzo: decrescente',
                                        'ASC_S' => 'Posti: crescente', 
                                        'DESC_S' => 'Posti: decrescente'),
                'decorators' => $this->elementDecorators,
                'class' => 'form-control'
                    ));
            
            
          
            $this->addElement('submit', 'search', array('label' => 'RICERCA',
                                                        'decorators' => $this->buttonDecorators,
                                                        'class' => 'btn btn-success'
                ));
            
            $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			'Form'
		));
            
            
            
        }
    
    
}