<?php

class Application_Form_User_Utenti_Profile extends Application_Form_Abstract{
    protected $email;
    protected $password;
    protected $user;

    public function __construct($user) {
        $this->user = $user;
        parent::__construct();
    }

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->email = $this->createElement('text', 'email', array('label' => 'Email: ', 'autofocus' => true, 'decorators' => $this->elementDecorators));
        $this->email->addValidator('regex', false, array('/^[\w\d.]+\@[\w\d.]+$/'))
                    ->setRequired(true)
                    ->addFilter('StringToLower');
        $this->email->getValidator('regex')->setMessage('Inserire una email valida');
        $this->email->setValue($this->user->Email);

        $this->password = $this->createElement('password', 'password', array('label' => 'Password: ', 'decorators' => $this->elementDecorators));
        $this->password->addValidator('StringLength', false, array(4))
                        ->setRequired(false);

        $this->addElement($this->email)
                ->addElement($this->password)
                ->addElement('submit', 'Modifica', array('label' => 'MODIFICA', 'decorators' => $this->buttonDecorators));
        
        $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			'Form'
		));
    }
}