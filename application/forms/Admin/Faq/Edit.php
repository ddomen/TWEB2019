<?php

class Application_Form_Admin_Faq_Edit extends Application_Form_Abstract
{
    protected $titolo;
    protected $testo;
    protected $punteggio;
    protected $faq;


    public function __construct($faq = null) {
        $this->faq = $faq;
        parent::__construct();
    }

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->titolo = $this->createElement('textarea', 'titolo', array('label' => 'Domanda: ', 'autofocus' => true, 'cols' => '120', 'rows' => '3','filters' => array('StringTrim'), 'decorators'=>$this->elementDecorators));
        $this->titolo->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(1, 150))
                        ->setRequired(true)
                        ->setAttrib('class', 'validation required')
                        ->addFilter('StringTrim');
        $this->titolo->getValidator('regex')->setMessage('Inserire una domanda valida');

        $this->testo = $this->createElement('textarea', 'testo', array('label' => 'Risposta: ', 'cols' => '120', 'rows' => '3','filters' => array('StringTrim'), 'decorators'=>$this->elementDecorators));
        $this->testo
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(1,150))
                        ->setRequired(true)
                        ->setAttrib('class', 'validation required')
                        ->addFilter('StringTrim');
        $this->testo->getValidator('regex')->setMessage('Inserire una risposta  valida');

        $this->punteggio = $this->createElement('text', 'punteggio', array('label' => 'Punteggio: ', 'decorators'=>$this->elementDecorators));
        $this->punteggio
                        ->addFilter('StringTrim')
                        ->addValidator('stringLength', false, array(1, 10))
                        ->addValidator('int', false, array('locale' => 'en_US'))
                        ->setAttrib('class', 'validation required integer')
                        ->setRequired(true);

        


        if($this->faq != null){
            $this->titolo->setValue($this->faq->Titolo);
            $this->testo->setValue($this->faq->Testo);
            $this->punteggio->setValue($this->faq->Punteggio);
        }

        $this
                ->addElement($this->titolo)
                ->addElement($this->testo)
                ->addElement($this->punteggio)
                ->addElement('submit', 'modifica', array('label' => 'MODIFICA FAQ',
                                                        'decorators' => $this->buttonDecorators));
        
        $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			'Form'
		));
        
        
    }
}
