<?php

class App_Form_Login extends Zend_Form{
    protected $username;
    protected $password;

    public function __construct($action = '') {
        parent::__construct();

        $this->setAction($action)
                ->setMethod('post');

        $this->username = $this->createElement('text', 'username');
        $this->username->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-z]+/'))
                        ->addValidator('stringLength', false, array(6, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        
        $this->password = $this->createElement('password', 'password');
        $this->password->addValidator('StringLength', false, array(6))
                        ->setRequired(true);

        $this->addElement($this->username)
                ->addElement($this->password)
                ->addElement('submit', 'login', array('label' => 'Login'));
    }
}