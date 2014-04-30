<?php

class Form_Login extends EasyBib_Form
{
    public function init() 
    {
        $this->setMethod('POST');
        $this->setName('login');
        $this->setAttrib('class', 'form-horizontal');
        
        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Conta:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('placeholder', 'Digite o email')
                ->setAttrib('class', 'input-medium');
        $this->addElement($login);
        
        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel('Senha:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'input-medium')
                ->setAttrib('placeholder', 'Digite a Senha');
        $this->addElement($senha);
        
        $submit = new Zend_Form_Element_Button('submit');
        $submit->setValue('Entrar')
                ->setLabel('Entrar')
                ->isValid(false);
        $submit->setAttrib('type', 'submit')
                ->setAttrib('class', 'btn btn-info');
        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit');
    }
}