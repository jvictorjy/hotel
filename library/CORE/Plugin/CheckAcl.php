<?php

class CORE_Plugin_CheckAcl extends Zend_Controller_Plugin_Abstract
{
    // Setando o modulo quando nao tem usuario logado do default
    private $_noauth = array( 
        'module' => 'default', 
        'controller' => 'auth', 
        'action' => 'index' 
    );
    // Setando o modulo quando nao tem permissao de acesso
    private $_noacl = array( 
        'module' => 'default', 
        'controller' => 'auth', 
        'action' => 'nao-autorizado' 
    );

    public function dispatchLoopStartup( Zend_Controller_Request_Abstract $request )
    {
        $acl = new Model_ACL();

        // Auth
        $auth = Zend_Auth::getInstance();
        $bOk = false;
        // Associa o perfil de visitante como default
        $role = 'guest';

        if( $request->getControllerName() != 'error' )
        {
            if( $auth->hasIdentity() )
            {
                // Caso tenha, pega dados do usuario
                $identity = (array)$auth->getIdentity();
                
                if( $identity['grupo_id'] == 9 )
                {
                    $role = 'admin';
                }
                else if( $identity['grupo_id'] == 2 )
                {
                    $role = 'tutor';
                }
                else
                {
                    $role = 'user';
                }
            }
            
            Zend_Registry::set( 'role', $role );
            
            $controller = strtolower($request->controller);
            $action = strtolower($request->action);
            $module = strtolower($request->module);
            $resource = $module.':'.$controller;

            if( !$acl->has( strtolower( $resource ) ) )
            {
                $resource = null;
            }

            if( !$acl->isAllowed( $role, $resource, $action ) )
            {
                //Nao está logado, logo nao tem permissao
                if( !$auth->hasIdentity() )
                {
                    $module = $this->_noauth['module'];
                    $controller = $this->_noauth['controller'];
                    $action = $this->_noauth['action'];
                 }
                else
                {
                    // Está logado e nao tem permissao
                    $module = $this->_noacl['module'];
                    $controller = $this->_noacl['controller'];
                    $action = $this->_noacl['action'];
                }

                $bOk = true;
            }
            
            // Nao tem permissao, carrega o modulo de sem permissao ou sem usuario logado
            if( $bOk )
            {
                $request->setModuleName($module);
                $request->setControllerName($controller);
                $request->setActionName($action);
            }
        }
    }
}