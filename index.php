<?php
use Main\Core\Router;
use Main\Core\Request;

// Vi behöver lägga till dessa tre rader för att kunna använda oss av Twig 2.0.
/*require_once __DIR__ . "/vendor/autoload.php";
$loader = new Twig_Loader_Filesystem(__DIR__);
$twig = new Twig_Environment($loader); */

// Twig 3.0
require_once "./vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader("./src/Views");
$twig = new \Twig\Environment($loader, [
    //'cache' => "./compilation_cache",
]);

// Vi skapar objekt av klasserna Request och Router.
$request = new Request();
$router = new Router();

// Vi anropar route I Router-objektet, som returnerar
// den färdiga HMTL-koden, som vi skriver ut med echo.
echo $router->route($request, $twig);
?>