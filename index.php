<?php
use Main\core\Router;
use Main\core\Request;
use Main\core\Config;
use Main\utils\DependencyInjector;

// Twig 3.0
require_once "./vendor/autoload.php";

$config = new Config();
$dbConfig = $config->get("database");

$loader = new \Twig\Loader\FilesystemLoader('./src/views');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('baseUrl', $config->get('baseUrl'));
// baseUrl to be used in twig files instead of a hardcoded path to js/css

$dsn = "mysql:host=".$dbConfig['host'].";dbname=".$dbConfig['database'].";charset=".$dbConfig['charset'];
$db = new PDO($dsn, $dbConfig["user"], $dbConfig["password"]);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$di = new DependencyInjector();
$di->set('PDO', $db);
$di->set('Twig', $twig);
$di->set('Config', $config);

$router = new Router($di);
$response = $router->route(new Request());
echo $response;
