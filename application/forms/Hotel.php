<?php

class Form_Hotel extends EasyBib_Form
{
    public function init()
    {
        
        $this->setMethod('POST');
        $this->setName('hotel');
        $this->setAttrib('class', 'form-horizontal');

        $id = new Zend_Form_Element_Hidden('id');
        $id->setRequired(false);
        $this->addElement($id);

        $hotelExistente = new Zend_Validate_Db_NoRecordExists('hoteis', 'nome');
        $hotelExistente->setMessage('Já existe um hotel com esse nome.', Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND);
        $hotel = new Zend_Form_Element_Text('nome');
        $hotel->setLabel('Nome:')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator($hotelExistente)
                ->setAttrib('class', 'span4 text');
        $this->addElement($hotel);
        
        $tempoLimite = new Zend_Form_Element_Select('estrelas');
        $tempoLimite->setLabel('Estrelas:')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span3 select1');
        $tempoLimite->addMultiOption(NULL, '-- Selecione --');
        for ($i = 2; $i < 6; $i++)
        {
            $tempoLimite->addMultiOption($i, $i . " estrelas");
        }
        $this->addElement($tempoLimite); 
        
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