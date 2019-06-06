<?php

class App_Form_Signin extends Zend_Form{
    protected $nome;
    protected $cognome;
    protected $username;
    protected $residenza;
    protected $email;
    protected $nascita;
    protected $condizioni;
    protected $occupazione;
    protected $occupazioni;

    public function __construct($occupazioni) {
        parent::__construct();
        $this->occupazioni = $occupazioni;
    }

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->nome = $this->createElement('text', 'nome', array('label' => 'Nome: '));
        $this->nome->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->nome->getValidator('regex')->setMessage('Inserire un nome valido');

        $this->username = $this->createElement('text', 'username', array('label' => 'Username: '));
        $this->username->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-z0-9]+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->username->getValidator('regex')->setMessage('Il nome utente può contenere solo caratteri alfanumerici');
        

        $this->cognome = $this->createElement('text', 'cognome', array('label' => 'Cognome: '));
        $this->cognome->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->cognome->getValidator('regex')->setMessage('Inserire un cognome valido');

        $this->residenza = $this->createElement('text', 'residenza', array('label' => 'Residenza: '));
        $this->residenza->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \',0-9]+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        $this->residenza->getValidator('regex')->setMessage('Inserire una residenza valida');

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
        

        $this->password = $this->createElement('password', 'password', array('label' => 'Password: '));
        $this->password->addValidator('StringLength', false, array(6))
                        ->setRequired(true);

        $this->condizioni = $this->createElement('checkbox', 'condizioni', array('label' => 'Accetta i Terminini di utilizzo: '));
        $this->condizioni->setRequired(true);

        $this->addElement($this->nome)
                ->addElement($this->cognome)
                ->addElement($this->username)
                ->addElement($this->residenza)
                ->addElement($this->email)
                ->addElement($this->nascita)
                ->addElement($this->password)
                ->addElement($this->condizioni)
                ->addElement('submit', 'Registra', array('label' => 'Registra'));
    }
}