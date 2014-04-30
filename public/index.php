<?php

ob_start("ob_gzhandler");

if (!function_exists('sha256')) {

    // hack pq o server nao tem a sha256()
    function sha256($var)
    {
        return hash('sha256', $var);
    }

}

if (!function_exists('detectEncoding')) {

    function detectEncoding($string)
    {
        static $list = array('utf-8', 'windows-1251');

        foreach ($list as $item)
        {
            $sample = iconv($item, $item, $string);
            if (md5($sample) == md5($string)) {
                return $item;
            }
        }

        return null;
    }

}

define( 'BASE_URL',substr($_SERVER['PHP_SELF'],0,strpos($_SERVER['PHP_SELF'] ,'/public/index.php')));
define( 'ROOT_DIR', dirname( dirname( __FILE__ ) ) );
define( 'APPLICATION_PATH', ROOT_DIR . '/application' );
define( 'DATA_PATH', realpath(APPLICATION_PATH . '/../data') );
define( 'PUBLIC_PATH', ROOT_DIR . '/public' );
define( 'PUBLIC_ONLINE_PATH', 'http://viajeprevenido.dfsolucoes.com');

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR
                , array(realpath(APPLICATION_PATH . '/../library')
            , get_include_path())));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
$application->bootstrap()
        ->run();
#ob_flush(); flush();
