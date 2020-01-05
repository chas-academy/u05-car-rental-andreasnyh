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

/*
$object = new Customers;
echo($object->getCustomers());
echo ("<h1>");
echo($object->findSinglePerson());
echo ("</h1>");
*/

/*

//$connection = login();
//$request = new Request();                    // En request innehåller path och form
//$router = new Router($connection, $request); // Dirigerar begäran till rätt controller
$question = 'SELECT * FROM Customers';
$query = $connection->prepare($question, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$query->execute();
$customers = $query->fetchALL();
while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    echo $customers."<br/>";
}
$statement = $connection->prepare($query);
echo $statement->execute();
//echo $router->route($request, $statement);

*/