<?php

class Application_Form_Public_Utenti_Login extends Application_Form_Abstract{
    protected $username;
    protected $password;

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->username = $this->createElement('text', 'username', array('label' => 'Utente: ', 'autofocus' => true));
        $this->username->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-z]+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->addFilter('StringToLower');
        
        $this->password = $this->createElement('password', 'password', array('label' => 'Password: '));
        $this->password->addValidator('StringLength', false, array(4))
                        ->setRequired(true);

        $this->addElement($this->username)
                ->addElement($this->password)
                ->addElement('submit', 'login', array('label' => 'Login'));
    }
}