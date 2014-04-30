<?php

class Default_IndexController extends CORE_Controller_Action
{

    private $_dbHotel;

    public function init()
    {
        parent::init();
        if (null === $this->_db) {
            $this->_db = new Model_Preco();
            $this->_dbHotel = new Model_Hotel();
        }
        
        $this->_form = new Form_Periodo();
        
        $this->view->controller = "Dashboard";
    }

    public function indexAction()
    {
        if ($this->_request->isPost()) {
            $this->_data = $this->_request->getPost();
            if ($this->_form->isValid($this->_data)) {
                $data = $this->_form->getValues();
                
                $hotel = $this->_db->listPrecos($data);
                $this->view->hotel = $this->_dbHotel->find($hotel['hotel']);
                $this->view->preco = $hotel['valor'];
            } else {
                $this->_form->populate($this->_data);
                $this->_form->buildBootstrapErrorDecorators();
                $this->flashMessenger->addMessage(array('error','Ocorreram erros! Verifique as mensagens abaixo.'));
            }
        }
        
        $this->_messages();
        $this->view->form = $this->_form;
    }

    public function dashboardAction()
    {
        
    }

}

