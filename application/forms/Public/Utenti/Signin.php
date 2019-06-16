<?php

class Application_Form_Public_Utenti_Signin extends Application_Form_Abstract{
    protected $nome;
    protected $cognome;
    protected $username;
    protected $residenza;
    protected $email;
    protected $nascita;
    protected $password;
    protected $condizioni;
    protected $occupazione;
    protected $occupazioni;
    protected $termini;
    protected $ruoli;
    protected $ruolo;

    public function __construct($occupazioni, $termini = true, $ruoli = null) {
        $this->occupazioni = $occupazioni;
        $this->termini = $termini;
        $this->ruoli = $ruoli;
        parent::__construct();
    }

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->nome = $this->createElement('text', 'nome', array('label' => 'Nome: ', 'autofocus' => true, 'decorators'=>$this->elementDecorators));
        $this->nome->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 150))
                        ->setAttrib('class', 'validation required name')
                        ->setRequired(true);
        $this->nome->getValidator('regex')->setMessage('Inserire un nome valido');

        $this->username = $this->createElement('text', 'username', array('label' => 'Username: ', 'decorators'=>$this->elementDecorators));
        $this->username->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-z0-9]+/'))
                        ->addValidator('stringLength', false, array(3, 150))
                        ->setRequired(true)
                        ->setAttrib('class', 'validation required username')
                        ->addFilter('StringToLower');
        $this->username->getValidator('regex')->setMessage('Il nome utente può contenere solo caratteri alfanumerici');
        

        $this->cognome = $this->createElement('text', 'cognome', array('label' => 'Cognome: ', 'decorators'=>$this->elementDecorators));
        $this->cognome->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 150))
                        ->setAttrib('class', 'validation required name')
                        ->setRequired(true);
        $this->cognome->getValidator('regex')->setMessage('Inserire un cognome valido');

        $this->residenza = $this->createElement('text', 'residenza', array('label' => 'Residenza: ', 'decorators'=>$this->elementDecorators));
        $this->residenza->addValidator('stringLength', false, array(3, 500))
                        ->setRequired(true);

        $this->email = $this->createElement('text', 'email', array('label' => 'Email: ', 'decorators'=>$this->elementDecorators));
        $this->email->addValidator('regex', false, array('/^[\w\d.]+\@[\w\d.]+$/'))
                    ->setRequired(true)
                        ->setAttrib('class', 'validation required email')
                        ->addFilter('StringToLower');
        $this->email->getValidator('regex')->setMessage('Inserire una email valida');

        $this->nascita = $this->createElement('text', 'nascita', array('label' => 'Nascita: ', 'decorators'=>$this->elementDecorators));
        $this->nascita->addValidator('regex', false, array('/^\d\d[\-\/]\d\d[-\/]\d\d\d\d$/'))
                    ->setRequired(true)
                    ->setAttrib('class', 'validation required date')
                    ->addFilter('StringToLower');
        $this->nascita->getValidator('regex')->setMessage('Inserire la data nel formato gg/mm/aaaa');
        

        $this->password = $this->createElement('password', 'password', array('label' => 'Password: ', 'decorators'=>$this->elementDecorators));
        $this->password->addValidator('StringLength', false, array(4, 32))
                        ->setAttrib('class', 'validation required')
                        ->setRequired(true);

        $this->occupazione = $this->createElement('select', 'occupazione', array('label' => 'Occupazione: ', 'decorators'=>$this->elementDecorators));
        $this->occupazione->addMultiOptions($this->occupazioni)
                            ->setRequired(true);

        $this->addElement($this->nome)
                ->addElement($this->cognome)
                ->addElement($this->username)
                ->addElement($this->residenza)
                ->addElement($this->email)
                ->addElement($this->nascita)
                ->addElement($this->password)
                ->addElement($this->occupazione);

        if(!!$this->termini){
            $this->condizioni = $this->createElement('checkbox', 'condizioni', array('label' => 'Accetta i Terminini di utilizzo: ', 'decorators'=>$this->elementDecorators));
            $this->condizioni->setRequired(true);
            $this->addElement($this->condizioni);
        }

        if($this->ruoli != null){
            $this->ruolo = $this->createElement('select', 'Ruolo', array('label' => 'Ruolo: ', 'decorators'=>$this->elementDecorators));
            $this->ruolo->addMultiOptions($this->ruoli)->setRequired(true);
            $this->addElement($this->ruolo);
        }

        $this->addElement('submit', 'Registra', array('label' => 'REGISTRA UTENTE', 'decorators' => $this->buttonDecorators));
        
        $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			'Form'
		));
    }
}