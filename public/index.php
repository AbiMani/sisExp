<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    $loader = new Loader();

    $loader->registerDirs(
        [
            APP_PATH . '/controllers/',
            APP_PATH . '/models/',
        ]
    );

    $loader->register();

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    // Configurar la vista
    $di->set(
        'view',
        function () {
            $view = new View();
            $view->setViewsDir(APP_PATH . '/views/');
        return $view;
        }
    );

    // Configuramos el URI base
    $di->set(
        'url',
        function () {
            $url = new UrlProvider();
            $url->setBaseUri('/');
        return $url;
        }
    );

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    $response = $application->handle();
    $response->send();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
