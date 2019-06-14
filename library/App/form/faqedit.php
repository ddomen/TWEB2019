<?php

class App_Form_FaqEdit extends Zend_Form{
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

        $this->titolo = $this->createElement('text', 'titolo', array('label' => 'Domanda: ', 'autofocus' => true));
        $this->titolo
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->titolo->getValidator('regex')->setMessage('Inserire una domanda valida');

        $this->testo = $this->createElement('text', 'testo', array('label' => 'Risposta: '));
        $this->testo
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->testo->getValidator('regex')->setMessage('Inserire una risposta  valida');

        $this->punteggio = $this->createElement('text', 'testo', array('label' => 'Punteggio: '));
        $this->punteggio
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->punteggio->getValidator('regex')->setMessage('Inserire un punteggio valido');

        


        if($this->faq != null){
            $this->titolo->setValue($this->faq->Titolo);
            $this->testo->setValue($this->faq->Testo);
            $this->punteggio->setValue($this->faq->Punteggio);
            
        }

        $this
                ->addElement($this->titolo)
                ->addElement($this->testo)
                ->addElement($this->punteggio)
                ->addElement('submit', 'Modifica', array('label' => 'Modifica'));
    }
}