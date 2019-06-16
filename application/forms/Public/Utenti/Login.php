<?php

class Application_Form_Public_Utenti_Login extends Application_Form_Abstract{
    protected $username;
    protected $password;

    public function init() {
        $this->setAction('')
                ->setMethod('post');

        $this->username = $this->createElement('text', 'username', array('label' => 'Utente: ', 'autofocus' => true, 'decorators'=>$this->elementDecorators));
        $this->username->addValidator('alnum')
                        ->addValidator('regex', false, array('/^[a-z0-9]+/'))
                        ->addValidator('stringLength', false, array(3, 20))
                        ->setRequired(true)
                        ->setAttrib('class', 'form-control validation required name')
                        ->addFilter('StringToLower');
        
        $this->password = $this->createElement('password', 'password', array('label' => 'Password: ', 'decorators'=>$this->elementDecorators));
        $this->password->addValidator('StringLength', false, array(4))
                        ->setAttrib('class', 'form-control validation required')
                        ->setRequired(true);

        $this->addElement($this->username)
                ->addElement($this->password)
                ->addElement('submit', 'login', array('label' => 'Login', 'decorators'=>$this->buttonDecoratorsLogin, 'class'=>'btn btn-success'));
        
        
        $this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'table')),
			'Form'
		));       
    }
}