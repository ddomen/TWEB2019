<?php
class Application_Form_Staff_Macchine_Modify extends Zend_Form
{
	//protected $_staffModel; //Valutare se può servire pescare dati dal db in questo caso

	public function init()
	{
		//$this->_staffModel = new Application_Model_Staff();
		$this->setMethod('post');
		$this->setName('modify');
		$this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
        

		$this->addElement('text', 'targa', array(
            'label' => 'TARGA',
            'required' => true,
            'description' => 'testo di descrizione',
            'validators' => array(array('StringLength',true, array(1,25))),
		));
		$this->addElement('text', 'modello', array(
            'label' => 'Modello',
            'filters' => array('StringTrim'),
            'required' => true,
        		'description' => 'testo di descrizione',
            'validators' => array(array('StringLength',true, array(1,25))),
		));

		$this->addElement('text', 'marca', array(
            'label' => 'Marca',
            'required' => true,
            'description' => 'testo di descrizione',
            'validators' => array(array('StringLength',true, array(1,25))),
        ));
        
        $this->addElement('text', 'price', array(
            'label' => 'Prezzo',
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'validators' => array(array('Float', true, array('locale' => 'en_US'))),
		));

		$this->addElement('file', 'image', array(
			'label' => 'Immagine',
			'destination' => APPLICATION_PATH . '/../public/images/products',
			'validators' => array( 
			array('Count', false, 1),
			array('Size', false, 102400),
			array('Extension', true, array('jpg', 'gif'))),
			));


		$this->addElement('textarea', 'allestimento', array(
            'label' => 'Allestimento',
        		'cols' => '60', 'rows' => '20',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,2500))),
		));

		$this->addElement('submit', 'add', array(
            'label' => 'Modifica Macchina',
		));
	}}