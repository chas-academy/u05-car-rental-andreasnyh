<?php
use Main\Core\Router;
use Main\Core\Request;
use Main\Core\Login;

// Twig 3.0
require_once "./vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader("./src/Views");
$twig = new \Twig\Environment($loader
//    , ['cache' => "./compilation_cache"]
    );

// Vi skapar objekt av klasserna Request och Router.
//$request = new Request();
//$router = new Router();

// Vi anropar route I Router-objektet, som returnerar
// den färdiga HMTL-koden, som vi skriver ut med echo.
//echo $router->route($request, $twig);

$connection = new login();
$request = new Request();                    // En request innehåller path och form
$router = new Router($connection, $request); // Dirigerar begäran till rätt controller
echo $router->route($request, $twig);
?>