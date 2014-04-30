<?php

class Form_Usuario extends EasyBib_Form {

    public function init() {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        $objPerfil = new Model_Perfil();
        $perfis = $objPerfil->fetchAll(null, null, "nomePerfil ASC");

        $this->setMethod('POST');
        $this->setName('usuarios');
        $this->setAttrib('class', 'form-horizontal');

        $id = new Zend_Form_Element_Hidden('id');
        $id->setRequired(false);
        $this->addElement($id);
        
        $perfil = new Zend_Form_Element_Select('idPerfil');
        $perfil->setLabel('Perfil:')
                ->setRequired(false)
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span3 select1');
        $perfil->addMultiOption(NULL, '-- Selecione --');
        foreach ($perfis as $p)
        {
            $perfil->addMultiOption($p['id'], $p['nomePerfil']);
        }
        $this->addElement($perfil);
        

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span7 text')
                ->setAttrib('placeholder', 'Digite o Nome');
        $this->addElement($nome);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator('EmailAddress')
                ->setAttrib('class', 'span4 text')
                ->setAttrib('placeholder', 'Digite o E-mail');
        $this->addElement($email);

        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel('Senha:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span4 text')
                ->setAttrib('placeholder', 'Digite a Senha');
        $this->addElement($senha);

        $submit = new Zend_Form_Element_Button('submit');
        $submit->setValue('Gravar')
                ->setLabel('Gravar')
                ->isValid(false);
        $submit->setAttrib('type', 'submit')
                ->setAttrib('class', 'btn btn-success');
        $this->addElement($submit);

//        $cancelar = new Zend_Form_Element_Button('cancelar');
//        $cancelar->setValue('Cancelar')
//                ->setLabel('cancelar')
//                ->isValid(false);
//        $cancelar->setAttrib('type', 'button')->setAttrib('class', 'btn');
//        $this->addElement($cancelar);

        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancelar');
    }

}