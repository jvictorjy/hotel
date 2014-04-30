<?php

/**
* ControllerAction para ser usado de forma onde tudo 
* que seja compartilhado entre todos os Actions 
* possa ser adicionado aqui e os Controllers devem 
* extender essa classe.
*/
class CORE_Controller_Action extends Zend_Controller_Action
{
	protected $_data = null;
	protected $_auth = false;
	protected $flashMessenger = null;
    protected $_infoUser = null;
    protected $_tipoPagina = 'normal';
    protected $_eUsuario = false;
    protected $_perfil = false;
    protected $_logado = false;
    protected $_cache = false;
    protected $_menuAtivo = array();
    protected $_db = null;
    protected $_form = null;

    public function init()
	{
		$this->view->tipoPagina = $this->_tipoPagina;
        $this->flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->view->messages = $this->flashMessenger->getMessages();
        
		$this->_cache = Zend_Registry::get('cache');

		if ($this->_request->isPost()) {
			$this->_data = $this->_request->getPost();
			if (isset($this->_data['submit'])) {
				unset($this->_data['submit']);
			}
			if (isset($this->_data['Enviar'])) {
				unset($this->_data['Enviar']);
			}
		}
        
//		$this->_auth = new Model_Auth();
//		$this->view->auth = $this->_auth;
//
//		if( ( $this->_request->getControllerName() == 'auth' )
//			&& ( $this->_request->getActionName() == 'login' )
//			&& ( $this->_auth->isLogado() === true ) ) {
//			$this->_redirect('/');
//		}
//
//        // Se estiver logado
//		if( $this->_auth->isLogado() === true ) {
//			$this->_logado = true;
//	        $this->_infoUser = $this->_auth->getData();
//	        $this->view->infoUser = $this->_infoUser;
//			$this->_perfil = Zend_Registry::get('role');
//
//	        if( $this->_infoUser->grupo_id != 9 )
//	        {
//				$this->_eUsuario = true;
//	        }
//		}
		
//		$this->view->eUsuario = $this->_eUsuario;
//		$this->view->perfil = $this->_perfil;
//		$this->view->logado = $this->_logado;

//		if( array_key_exists( $this->_request->getControllerName(), $this->_menuAtivo ) )
//		{
//			$this->_menuAtivo[$this->_request->getControllerName()] = $this->_menuAtivo[$this->_request->getControllerName()] . ' ' . $this->_menuAtivo[$this->_request->getControllerName()] . '-active';
//		}
//
//		$this->view->menuAtivo = $this->_menuAtivo;
//		$this->view->controllerName = $this->_request->getControllerName();
	}

	protected function _limpaParametros()
	{
		$params = $this->getRequest()->getParams();

		unset($params['controller']);
        unset($params['action']);
        unset($params['module']);
        unset($params['submit']);

        return $params;
	}
    
    protected function _messages() {
        $this->view->messages = array_merge(
            $this->flashMessenger->getMessages(),
            $this->flashMessenger->getCurrentMessages()
        );
        $this->flashMessenger->clearCurrentMessages();        
    }
    
    
}
