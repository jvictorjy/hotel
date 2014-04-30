<?php

class Form_Preco extends EasyBib_Form {

    public function init() {
        $objTipoPreco = new Model_TipoPreco();
        $tipoPreco = $objTipoPreco->fetchAll(null, null, "descricao ASC");

        $objTipoCliente = new Model_TipoCliente();
        $tipoCliente = $objTipoCliente->fetchAll(null, null, "descricao ASC");

        $objHotel = new Model_Hotel();
        $hoteis = $objHotel->fetchAll(null, null, "nome ASC");
        
        $this->setMethod('POST');
        $this->setName('preco');
        $this->setAttrib('class', 'form-horizontal');

        $id = new Zend_Form_Element_Hidden('id');
        $id->setRequired(false);
        $this->addElement($id);
        
        $hotel = new Zend_Form_Element_Select('hotel_id');
        $hotel->setLabel('Hotel:')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span3 select1');
        $hotel->addMultiOption(NULL, '-- Selecione --');
        foreach ($hoteis as $h)
        {
            $hotel->addMultiOption($h['id'], $h['nome']);
        }
        $this->addElement($hotel);

        $tipo = new Zend_Form_Element_Select('tipo_id');
        $tipo->setLabel('Dias:')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span3 select1');
        $tipo->addMultiOption(NULL, '-- Selecione --');
        foreach ($tipoPreco as $tp)
        {
            $tipo->addMultiOption($tp['id'], $tp['descricao']);
        }
        $this->addElement($tipo);
        
        $cliente = new Zend_Form_Element_Select('tipo_cliente_id');
        $cliente->setLabel('Tipo de Cliente:')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span3 select1');
        $cliente->addMultiOption(NULL, '-- Selecione --');
        foreach ($tipoCliente as $tc)
        {
            $cliente->addMultiOption($tc['id'], $tc['descricao']);
        }
        $this->addElement($cliente);

        $valor = new Zend_Form_Element_Text('valor');
        $valor->setLabel('Preco (U$):')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class', 'span3 text')
                ->setAttrib('placeholder', 'Digite o valor');
        $this->addElement($valor);


        $submit = new Zend_Form_Element_Button('submit');
        $submit->setValue('Gravar')
                ->setLabel('Gravar')
                ->isValid(false);
        $submit->setAttrib('type', 'submit')
                ->setAttrib('class', 'btn btn-success');
        $this->addElement($submit);

        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancelar');
    }

}