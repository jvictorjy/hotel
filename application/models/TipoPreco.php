<?php

class Model_TipoPreco extends CORE_Model_Abstract
{
    
    public function __construct()
    {
        $this->_dbTable = new Model_DbTable_TiposPrecos();
    }
    
    public function vereficarDia($dia)
    {
        $diaa=substr($dia,0,2)."-";
        $mes=substr($dia,3,2)."-";
        $ano=substr($dia,6,4);

        $diasemana = date("w", mktime(0,0,0,$mes,$diaa,$ano) );
        
        return $diasemana;
    }
}