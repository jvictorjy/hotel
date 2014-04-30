<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

        Zend_Registry::set('config', $config);
//        Zend_Registry::set('mail', $config->resources->mail);
        #Zend_Registry::set( 'log_stream', $config->resources->log->stream );
        Zend_Registry::set('log_stream', '/logs/atividades.log');
        Zend_Registry::set('cacheConfig', $config->resources->cachemanager);
        Zend_Registry::set('default_language', $config->resources->translate->default_language);

        $autoloader = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'App',
                'basePath' => APPLICATION_PATH . '/modules/default'
            ));
        $autoloader->addResourceType('mail', 'mails', 'Mail');
        date_default_timezone_set($config->date_default_timezone); // Seta timezone
    }

    protected function _initCache()
    {
        $cache = Zend_Cache::factory(Zend_Registry::get('cacheConfig')->database->frontend->name
                        , Zend_Registry::get('cacheConfig')->database->backend->name
                        , Zend_Registry::get('cacheConfig')->database->frontend->options->toArray()
                        , Zend_Registry::get('cacheConfig')->database->backend->options->toArray()
                        , Zend_Registry::get('cacheConfig')->database->frontend->customFrontendNaming
                        , Zend_Registry::get('cacheConfig')->database->backend->customBackendNaming);

        Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
        Zend_Locale::setCache($cache);
        Zend_Currency::setCache($cache);

        Zend_Registry::set('cache', $cache);
    }

    protected function _initViews()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        Zend_Registry::set('view', $view);

        // Add Helpers
        $view->addHelperPath('CORE/View/Helper/', 'CORE_View_Helper');
        $view->addHelperPath('Noumenal/View/Helper/', 'Noumenal_View_Helper');
        $view->addHelperPath('EasyBib/View/Helper', 'EasyBib_View_Helper');

        $view->doctype('HTML5');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'charset=UTF-8');
        $view->headTitle('Hotel Management')->setSeparator(' | ');
    }

    protected function _initLocales()
    {
        $locale = new Zend_Locale('pt_BR');
        Zend_Registry::set('locale', $locale);
    }

    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(
                        array(
                            'basePath' => APPLICATION_PATH
                            , 'namespace' => ''
                        )
        );

        return $autoloader;
    }

    protected function _initLog()
    {
        $log = new CORE_Log(DATA_PATH . '/logs/');
        $log->iniciaConfig(array('email.log'));

        Zend_Registry::set('log', $log);
    }

//    protected function _initMail()
//    {
//        $config = array(
//            'auth' => Zend_Registry::get('mail')->transport->auth
//            , 'username' => Zend_Registry::get('mail')->transport->username
//            , 'password' => Zend_Registry::get('mail')->transport->password
//        );
//
//        if (!empty(Zend_Registry::get('mail')->transport->ssl))
//            $config['ssl'] = Zend_Registry::get('mail')->transport->ssl;
//
//        if (!empty(Zend_Registry::get('mail')->transport->port))
//            $config['port'] = Zend_Registry::get('mail')->transport->port;
//
//        $transport = new Zend_Mail_Transport_Smtp(Zend_Registry::get('mail')->transport->host, $config);
//
//        Zend_Registry::set('transport', $transport);
//
//        Zend_Mail::setDefaultFrom(Zend_Registry::get('mail')->defaultFrom->email
//                , Zend_Registry::get('mail')->defaultFrom->name);
//
//        Zend_Mail::setDefaultReplyTo(Zend_Registry::get('mail')->defaultReplyTo->email
//                , Zend_Registry::get('mail')->defaultReplyTo->name);
//
//        $log = null;
//        if (Zend_Registry::get('config')->core->email->log) {
//            $writer = new Zend_Log_Writer_Stream(Zend_Registry::get('config')->core->email->logPath);
//            $log = new Zend_Log($writer);
//        }
//
//        CORE_Email::getInstance()->config(
//                array(
//                    'viewPath' => Zend_Registry::get('config')->core->email->viewPath
//                    , 'alertTo' => Zend_Registry::get('config')->core->email->alertTo
//                    , 'transport' => $transport
//                    , 'log' => $log
//                )
//        );
//    }

    protected function _initGlobalFilters()
    {
        $filters = array('StripTags', 'StringTrim'); //remove tags e espaços para evitar problemas de seguranca
        $post = new Zend_Filter_Input($filters, NULL, $_POST);
        $post->setDefaultEscapeFilter(new Zend_Filter_StringTrim());

        Zend_Registry::set('post', $post);
    }

    public function _initRouter()
    {
        // $this->bootstrap('frontController');
        // $frontController = $this->getResource('frontController');
        // $router = $frontController->getRouter();
        // $route = new Zend_Controller_Router_Route(
        //                 'emprestimos/view/:id',
        //                 array(
        //                     'module' => 'default',
        //                     'controller' => 'chamados',
        //                     'action' => 'view',
        //                     'id' => ''
        //                 )
        // );
        // $router->addRoute('chamadosVisualizacao', $route);
    }

    /**
     * Configurar Navegação
     * @return null
     */
//    protected function _initNavigationConfig()
//    {
//        // Nome do Arquivo
//        $filename = realpath(APPLICATION_PATH . '/configs/navigation.xml');
//        // Carregamento de Configuração
//        $config = new Zend_Config_Xml($filename);
//
//        // Registrar Camada de Visualização
//        $this->registerPluginResource('view');
//        // Inicialização da Camada
//        $view = $this->bootstrap('view')->getResource('view');
//
//        // Captura do Auxiliar de Navegação
//        $navigation = $view->navigation();
//        // Incluir Conteúdo
//        $navigation->addPages($config);
//    }

}

