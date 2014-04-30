<?php

class Default_PrecosController extends CORE_Controller_Action
{

    public function init()
    {
        parent::init();
        if (null === $this->_db) {
            $this->_db = new Model_Preco();
        }

        $this->_form = new Form_Preco();
        
        
        $this->_redirecionar = "/precos";
        $this->view->controller = "Pre&ccedil;os";
    }
    
    public function indexAction() {
        $this->view->data = $this->_db->fetchAll();
    }
    
    public function newAction() 
    {

        if ($this->_request->isPost()) {
            $this->_data = $this->_request->getPost();
            if ($this->_form->isValid($this->_data)) {
                $data = $this->_form->getValues();
                
                if ($this->_db->_insert($data)) {
                    $this->flashMessenger->addMessage(array('success', 'Registro cadastrado com sucesso!'));
                } else {
                    $this->flashMessenger->addMessage(array('error', 'Não foi possível cadastrar.'));
                }
                $this->_redirect($this->_redirecionar);
            } else {
                $this->_form->populate($this->_data);
                $this->_form->buildBootstrapErrorDecorators();
                $this->flashMessenger->addMessage(array('error','Ocorreram erros! Verifique as mensagens abaixo.'));
            }
        }
        $this->_messages();
        $this->view->form = $this->_form;
    }

    public function editAction() 
    {

        if ($this->_request->isPost()) {
            $this->_data = $this->_request->getPost();
            if ($this->_form->isValid($this->_data)) {
                $data = $this->_form->getValues();

                if ($this->_db->_update($data)) {
                    $this->flashMessenger->addMessage(array('success', 'Registro editado com sucesso!'));
                } else {
                    $this->flashMessenger->addMessage(array('error', 'Não foi possível editar o registro.'));
                }
                $this->_redirect($this->_redirecionar);
            } else {
                $this->_form->populate($this->_data);
                $this->_form->buildBootstrapErrorDecorators();
                $this->flashMessenger->addMessage(array('error', 'Ocorreram erros! Verifique as mensagens abaixo.'));
            }
        }

        $id = $this->_request->getParam('id', null);
        if (null === $id) {
            $this->flashMessenger->addMessage(array('error', 'Registro não identificado'));
            $this->_redirect($this->_redirecionar);
        } else {
            $this->_data = $this->_db->find($id);
            $this->_form->getElement('id')->setValue($id);
            
            $this->_form->populate($this->_data);
            $this->_form->buildBootstrapErrorDecorators();
            $this->view->form = $this->_form;
        }
        
        $this->_messages();
        $this->view->form = $this->_form;
    }
    
    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $id = $this->_request->getParam('id', null);
        
        if (null === $id) {
            $this->flashMessenger->addMessage(array('error', 'Registro não identificado'));
            $this->_redirect($this->_redirecionar);
        } else {
            
            if ($this->_db->delete($id)) {
                $this->flashMessenger->addMessage(array('success', 'Registro excluído com sucesso!'));
            } else {
                $this->flashMessenger->addMessage(array('error', 'Registro não deletado.'));
            }
        }
        $this->_redirect($this->_redirecionar);
    }
    
}