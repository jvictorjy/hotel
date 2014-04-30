<?php

class Form_Perfil extends EasyBib_Form
{
    public function init()
    {
        $modulos = Model_Modulo::listar();
        $moduloAcao = new Model_ModuloAcao();
        
        $this->setMethod('POST');
        $this->setName('perfis');
        $this->setAttrib('class', 'form-horizontal');

        $id = new Zend_Form_Element_Hidden('id');
        $id->setRequired(false);
        $this->addElement($id);

        $perfil = new Zend_Form_Element_Text('nomePerfil');
        $perfil->setLabel('Nome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span4 text');
        $this->addElement($perfil);        
        
        $submit = new Zend_Form_Element_Button('submit');
        $submit->setValue('Gravar')
                ->setLabel('Gravar')
                ->isValid(false);
        $submit->setAttrib('type', 'submit')
                ->setAttrib('class', 'btn btn-success');
        $this->addElement($submit);


        // $cancelar = new Zend_Form_Element_Button('cancelar');
        // $cancelar->setValue('Cancelar')
        //         ->setLabel('Cancelar')
        //         ->isValid(false);
        // $cancelar->setAttrib('type', 'button')->setAttrib('class', 'btn');
        // $this->addElement($cancelar);


        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancelar');
        
    }
}