<?php

class Model_Hotel extends CORE_Model_Abstract
{
    
    public function __construct()
    {
        $this->_dbTable = new Model_DbTable_Hoteis();
    }
    
}