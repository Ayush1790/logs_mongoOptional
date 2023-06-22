<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Logger;

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
require_once BASE_PATH.'/vendor/autoload.php';
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);


$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => 'mysql-server',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'phalconApp',
            ]
        );
    }
);

$container->set(
    'mongo',
    function () {
        $mongo = new MongoDB\Client('mongodb+srv://myAtlasDBUser:myatlas-001@myatlas' .
            'clusteredu.aocinmp.mongodb.net/?retryWrites=true&w=majority');
        return $mongo->products->user;
    },
    true
);

$container->set(
    'logger',
    function () {
        $attack = new  Phalcon\Logger\Adapter\Stream(APP_PATH . '/logs/attack.log');

        $logger  = new Logger(
            'messages',
            [
                'attack' => $attack,
            ]
        );
        return $logger;
    }
);
$container->set(
    'logger',
    function () {
        $attack = new  Phalcon\Logger\Adapter\Stream(APP_PATH . '/logs/attack.log');

        $logger  = new Logger(
            'messages',
            [
                'attack' => $attack,
            ]
        );
        return $logger;
    }
);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
