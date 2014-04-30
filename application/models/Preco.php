<?php

class Model_Preco extends CORE_Model_Abstract
{
    
    public function __construct()
    {
        $this->_dbTable = new Model_DbTable_Precos();
    }
    
    public function listPrecos($data)
    {
        $objHotel = new Model_Hotel();
        $objPreco = new Model_TipoPreco();
        
        $diasemana = $objPreco->vereficarDia($data['data_inicio']);
        
        $sql = $this->getDb()->select()
                    ->from($this->_dbTable->getName())
                    ->where('tipo_cliente_id = ?', $data['tipo_cliente_id']);
        
        if ($diasemana == 0 && $diasemana == 6) {
            $sql->where("tipo_id = ?", 2);
        } else {
            $sql->where("tipo_id = ?", 1);
        }
        
        $hoteis = $this->getDb()->fetchAll($sql);
        
        $valor = 0;
        $hotelGanhadorValor = array();
        $hotelClassificacao = 0;
        foreach ($hoteis as $hotel)
        {
            if ($valor == 0) {
                $hotelGanhadorValor['hotel'] = $hotel['hotel_id'];
                
                $hotelGanhador = $objHotel->find($hotel['hotel_id']);
                $hotelClassificacao = $hotelGanhador['estrelas'];
                $valor = $hotel['valor'];
                $hotelGanhadorValor['valor'] = $valor;
            } elseif ($valor > $hotel['valor']) {
                $hotelGanhadorValor['hotel'] = $hotel['hotel_id'];
                
                $hotelGanhador = $objHotel->find($hotel['hotel_id']);
                $hotelClassificacao = $hotelGanhador['estrelas'];
                $valor = $hotel['valor'];
                $hotelGanhadorValor['valor'] = $valor;
            } elseif ($valor == $hotel['valor']) {
                $hotelGanhador = $objHotel->find($hotel['hotel_id']);
                
                if ($hotelClassificacao < $hotelGanhador['estrelas']) {
                    $hotelGanhadorValor['hotel'] = $hotel['hotel_id'];
                    $hotelClassificacao = $hotelGanhador['estrelas'];
                    $valor = $hotel['valor'];
                    $hotelGanhadorValor['valor'] = $valor;
                }
            }
        }
        
        return $hotelGanhadorValor;
    }
    
}