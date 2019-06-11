<?php
class App_Form_CatalogFilter extends Zend_Form
{
	public function init() {
		$this->setMethod('post');
		$this->setName('filtercar');
		$this->setAction('');
                
                
            $this->addElement('text', 'modello', array(
                  'label' => 'Modello',
                  'filters' => array('StringTrim'),
                  'description' => 'Modello della macchina',
                  'validators' => array(array('StringLength', true, array(1,25))),
		));          
            
            $this->addElement('text', 'marca', array(
                  'label' => 'Marca',
                  'filters' => array('StringTrim'),
                  'description' => 'Marca della macchina',
                  'validators' => array(array('StringLength', true, array(1,25))),
		)); 
            
            $this->addElement('text', 'prezzoMin', array(
                  'label' => 'Prezzo Minimo',
                  'filters' => array('LocalizedToNormalized'),
                  'validators' => array(array('Float', true, array('locale' => 'en_US'))),
		));
            
            $this->addElement('text', 'prezzoMax', array(
                  'label' => 'Prezzo Massimo',
                  'filters' => array('LocalizedToNormalized'),
                  'validators' => array(array('Float', true, array('locale' => 'en_US'))),
		));
            
            $this->addElement('text', 'posti', array(
                  'label' => 'Posti',
                  'filters' => array('StringTrim'),
                  'validators' => array(array('StringLength', true, array(1,25))),
		));
          
            $this->addElement('submit', 'search', array('label' => 'RICERCA'));
            
        }
    
    
}