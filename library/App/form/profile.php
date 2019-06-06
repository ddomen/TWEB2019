<?php

class App_Form_Profile extends Zend_Form{
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

        $this->email = $this->createElement('text', 'email', array('label' => 'Email: '));
        $this->email->addValidator('regex', false, array('/^[\w\d.]+\@[\w\d.]+$/'))
                    ->setRequired(true)
                    ->addFilter('StringToLower');
        $this->email->getValidator('regex')->setMessage('Inserire una email valida');
        $this->email->setValue($this->user->Email);

        $this->password = $this->createElement('password', 'password', array('label' => 'Password: '));
        $this->password->addValidator('StringLength', false, array(6))
                        ->setRequired(false);

        $this->addElement($this->email)
                ->addElement($this->password)
                ->addElement('submit', 'Modifica', array('label' => 'Modifica'));
    }
}