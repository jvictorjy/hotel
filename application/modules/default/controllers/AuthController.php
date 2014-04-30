<?php

class Default_AuthController extends CORE_Controller_Action
{
    
    public function init() {
        parent::init();
        
    }
    
    public function indexAction()
    {
        $form = new Form_Login();
        $this->view->form = $form;
        
        $usuario = new Model_Usuario();
        
        if (!$this->_request->isPost()) {
            return false;
        }

        $data = $this->_request->getPost();
        
        if ($data['login'] == "" &&  $data['senha'] == "") {
            $this->flashMessenger->addMessage(array('error','Os dados informados (UsuÃ¡rio e/ou Senha) n&atilde;o s&atilde;o v&aacute;lidos.'));
            return false;
        }
        
        $db_adapter = $usuario->getDb();

        $objAuth = Zend_Auth::getInstance();

        $auth_adapter = new Zend_Auth_Adapter_DbTable($db_adapter, 'usuario', 'email', 'senha', 'sha1(?)');
        
        // Configura as credencias informadas pelo usuï¿½rio
        $auth_adapter->setIdentity($data['login']);
        $auth_adapter->setCredential($data['senha']);

        // Tenta autenticar o usuï¿½rio
        $objAuth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $result = $objAuth->authenticate($auth_adapter);
        
        /**
         * Se o usuï¿½rio for autenticado redireciona para a index e grava seus dados,
         * caso contrï¿½rio exibe uma mensagem de alerta na pï¿½gina
         */
        if ($result->isValid()) {
            /**
             * Pega os dados do usuï¿½rio, omitindo a senha
             * http://framework.zend.com/manual/en/zend.auth.adapter.dbtable.html
             */
            $authData = $auth_adapter->getResultRowObject(null, 'senha');
            
            // Armazena os dados do usuï¿½rio
            $objAuth->getStorage()->write($authData);

            $this->_redirect("/index/dashboard");
            
        } else {
            $this->flashMessenger->addMessage(array('error','Os dados informados (UsuÃ¡rio e/ou Senha) n&atilde;o s&atilde;o v&aacute;lidos.'));
        }
        $this->_messages();
    }
    
    public function logoutAction() {
        $objAuth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));

        // Limpa a autenticação
        $objAuth->clearIdentity();
        $this->_redirect("/");
    }
    
}