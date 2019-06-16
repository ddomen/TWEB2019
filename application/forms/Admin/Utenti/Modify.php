<?php

class Application_Form_Admin_Utenti_Modify extends Application_Form_Abstract{
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
    protected $user;
    protected $ruoli;
    protected $ruolo;

    public function __construct($occupazioni, $ruoli, $user = null) {
        $this->occupazioni = $occupazioni;
        $this->user = $user;
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
                        ->setAttrib('class', 'form-control validation required name')
                        ->setRequired(true);
        $this->nome->getValidator('regex')->setMessage('Inserire un nome valido');

        $this->cognome = $this->createElement('text', 'cognome', array('label' => 'Cognome: ', 'decorators'=>$this->elementDecorators));
        $this->cognome->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-zA-Z \']+/'))
                        ->addValidator('stringLength', false, array(3, 150))
                        ->setAttrib('class', 'form-control validation required name')
                        ->setRequired(true);
        $this->cognome->getValidator('regex')->setMessage('Inserire un cognome valido');

        $this->password = $this->createElement('text', 'password', array('label' => 'Password: ', 'decorators'=>$this->elementDecorators));
        $this->password->addValidator('StringLength', false, array(4, 32))
                        ->setAttrib('class', 'form-control validation required')
                        ->setRequired(true);

        $this->residenza = $this->createElement('text', 'residenza', array('label' => 'Residenza: ', 'decorators'=>$this->elementDecorators));
        $this->residenza->addValidator('stringLength', false, array(3, 500))
                        ->setAttrib('class', 'form-control validation required')
                        ->setRequired(true);

        $this->email = $this->createElement('text', 'email', array('label' => 'Email: ', 'decorators'=>$this->elementDecorators));
        $this->email->addValidator('regex', false, array('/^[\w\d.]+\@[\w\d.]+$/'))
                        ->setAttrib('class', 'form-control validation required email')
                        ->setRequired(true)
                    ->addFilter('StringToLower');
        $this->email->getValidator('regex')->setMessage('Inserire una email valida');

        $this->nascita = $this->createElement('text', 'nascita', array('label' => 'Nascita: ', 'decorators'=>$this->elementDecorators));
        $this->nascita->addValidator('regex', false, array('/^\d\d[\-\/]\d\d[-\/]\d\d\d\d$/'))
                    ->setAttrib('class', 'form-control validation required date')
                    ->setRequired(true)
                    ->addFilter('StringToLower');
        $this->nascita->getValidator('regex')->setMessage('Inserire la data nel formato gg/mm/aaaa');

        $this->occupazione = $this->createElement('select', 'occupazione', array('label' => 'Occupazione: ', 'decorators'=>$this->elementDecorators, 'class' => 'form-control'));
        $this->occupazione->addMultiOptions($this->occupazioni)
                            ->setRequired(true);

        $this->ruolo = $this->createElement('select', 'Ruolo', array('label' => 'Ruolo: ', 'decorators'=>$this->elementDecorators, 'class' => 'form-control'));
        $this->ruolo->addMultiOptions($this->ruoli)->setRequired(true);

        if($this->user != null){
            $this->nome->setValue($this->user->Nome);
            $this->cognome->setValue($this->user->Cognome);
            $this->password->setValue($this->user->Password);
            $this->residenza->setValue($this->user->Residenza);
            $this->email->setValue($this->user->Email);
            $this->nascita->setValue(preg_replace('/(\d{4})-(\d{2})-(\d{2}).*/', '$3/$2/$1', $this->user->Nascita));
            $this->occupazione->setValue($this->user->Occupazione);
            $this->ruolo->setValue($this->user->Ruolo);
        }

        $this->addElement($this->nome)
                ->addElement($this->cognome)
                ->addElement($this->password)
                ->addElement($this->residenza)
                ->addElement($this->email)
                ->addElement($this->nascita)
                ->addElement($this->occupazione)
                ->addElement($this->ruolo)
                ->addElement('submit', 'Modifica', array('label' => 'MODIFICA UTENTE',
                                                        'decorators' => $this->buttonDecorators,
                                                        'class' => 'btn btn-success'));
        
        
        $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			'Form'
		));
        
    }
}