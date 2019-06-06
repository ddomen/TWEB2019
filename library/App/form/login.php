<?php

class App_Form_Login extends Zend_Form{
    protected $username;
    protected $password;

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->username = $this->createElement('text', 'username', array('label' => 'Utente: '));
        $this->username->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-z]+/'))
                        ->addValidator('stringLength', false, array(4, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        
        $this->password = $this->createElement('password', 'password', array('label' => 'Password: '));
        $this->password->addValidator('StringLength', false, array(6))
                        ->setRequired(true);

        $this->addElement($this->username)
                ->addElement($this->password)
                ->addElement('submit', 'login', array('label' => 'Login'));
    }
}