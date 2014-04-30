<?php

class Form_Periodo extends EasyBib_Form
{

    public function init()
    {
        $objTipoCliente = new Model_TipoCliente();
        $tipoCliente = $objTipoCliente->fetchAll(null, null, "descricao ASC");

        $this->setMethod('POST');
        $this->setName('periodo');
        $this->setAttrib('class', 'form-horizontal');

        $dataInicio = new Zend_Form_Element_Text('data_inicio');
        $dataInicio->setLabel('Data:')
                ->setRequired(false)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span2 text datepicker');
        $this->addElement($dataInicio);

//        $dataFinal = new Zend_Form_Element_Text('data_final');
//        $dataFinal->setLabel('Data final:')
//                ->setRequired(false)
//                ->addFilter('StripTags')
//                ->addFilter('StringTrim')
//                ->addValidator('NotEmpty')
//                ->setAttrib('class', 'span2 text datepicker');
//        $this->addElement($dataFinal);
        
        $cliente = new Zend_Form_Element_Select('tipo_cliente_id');
        $cliente->setLabel('Cliente:')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span3 select1');
        $cliente->addMultiOption(NULL, '-- Selecione --');
        foreach ($tipoCliente as $tc)
        {
            $cliente->addMultiOption($tc['id'], $tc['descricao']);
        }
        $this->addElement($cliente);

        $submit = new Zend_Form_Element_Button('submit');
        $submit->setValue('Enviar')
                ->setLabel('Enviar')
                ->isValid(false);
        $submit->setAttrib('type', 'submit')
                ->setAttrib('class', 'btn btn-info');
        $this->addElement($submit);

        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancelar');
    }

}
