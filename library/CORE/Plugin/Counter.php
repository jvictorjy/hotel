<?php

class CORE_Plugin_Counter extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch( Zend_Controller_Request_Abstract $request )
    {
        $ocorrencias = new Model_Ocorrencia();

        Zend_Registry::set('counter', $ocorrencias->getEstatisticasTotal());
    }
}