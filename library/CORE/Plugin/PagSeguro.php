<?php

class CORE_Plugin_PagSeguro extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        require_once 'PagSeguroLibrary/PagSeguroLibrary.php';
        return $request;
    }

}
