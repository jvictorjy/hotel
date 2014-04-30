<?php

class Model_TipoCliente extends CORE_Model_Abstract
{
    
    public function __construct()
    {
        $this->_dbTable = new Model_DbTable_TiposClientes();
    }
    
}