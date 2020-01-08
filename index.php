<?php
use Main\core\Router;
use Main\core\Request;
use Main\core\Config;
use Main\includes\Login;
use Main\utils\DependencyInjector;
// Twig 3.0
require_once "./vendor/autoload.php";

$config = new Config();

$loader = new \Twig\Loader\FilesystemLoader('./src/views');
$twig = new \Twig\Environment($loader);

$connection = new Login();
#$connection->login();

$di = new DependencyInjector();
$di->set('Database', $connection);
$di->set('Twig', $twig);
$di->set('Config', $config);

$router = new Router($di);
$response = $router->route(new Request());
echo $response;
