<?php

class App_Form_UserEdit extends Zend_Form{
    protected $nome;
    protected $cognome;
    protected $username;
    protected $residenza;
    protected $email;
    protected $nascita;
    protected $condizioni;
    protected $occupazione;
    protected $occupazioni;
    protected $user;

    public function __construct($occupazioni, $user = null) {
        $this->occupazioni = $occupazioni;
        $this->user = $user;
        parent::__construct();
    }

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->nome = $this->createElement('text', 'nome', array('label' => 'Nome: ', 'autofocus' => true));
        $this->nome->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 150))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->nome->getValidator('regex')->setMessage('Inserire un nome valido');

        $this->cognome = $this->createElement('text', 'cognome', array('label' => 'Cognome: '));
        $this->cognome->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 150))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->cognome->getValidator('regex')->setMessage('Inserire un cognome valido');

        $this->password = $this->createElement('text', 'password', array('label' => 'Password: '));
        $this->password->addValidator('StringLength', false, array(4, 32))
                        ->setRequired(true);

        $this->residenza = $this->createElement('text', 'residenza', array('label' => 'Residenza: '));
        $this->residenza->addValidator('alnum')
                        ->addValidator('stringLength', false, array(3, 500))
                        ->setRequired(true)
                        ->addFilter('StringToLower');

        $this->email = $this->createElement('text', 'email', array('label' => 'Email: '));
        $this->email->addValidator('regex', false, array('/^[\w\d.]+\@[\w\d.]+$/'))
                    ->setRequired(true)
                    ->addFilter('StringToLower');
        $this->email->getValidator('regex')->setMessage('Inserire una email valida');

        $this->nascita = $this->createElement('text', 'nascita', array('label' => 'Nascita: '));
        $this->nascita->addValidator('regex', false, array('/^\d\d[\-\/]\d\d[-\/]\d\d\d\d$/'))
                    ->setRequired(true)
                    ->addFilter('StringToLower');
        $this->nascita->getValidator('regex')->setMessage('Inserire la data nel formato gg/mm/aaaa');

        $this->occupazione = $this->createElement('select', 'occupazione', array('label' => 'Occupazione: '));
        $this->occupazione->addMultiOptions($this->occupazioni)
                            ->setRequired(true);

        if($this->user != null){
            $this->nome->setValue($this->user->Nome);
            $this->cognome->setValue($this->user->Cognome);
            $this->password->setValue($this->user->Password);
            $this->residenza->setValue($this->user->Residenza);
            $this->email->setValue($this->user->Email);
            $this->nascita->setValue(preg_replace('/(\d{4})-(\d{2})-(\d{2}).*/', '$3/$2/$1', $this->user->Nascita));
            $this->occupazione->setValue($this->user->Occupazione);
        }

        $this->addElement($this->nome)
                ->addElement($this->cognome)
                ->addElement($this->password)
                ->addElement($this->residenza)
                ->addElement($this->email)
                ->addElement($this->nascita)
                ->addElement($this->occupazione)
                ->addElement('submit', 'Modifica', array('label' => 'Modifica'));
    }
}