<?php
use Main\core\Router;
use Main\core\Request;
use Main\includes\Login;
use Main\includes\Customers;
//include_once './src/Core/Login.php';

// Twig 3.0
require_once "./vendor/autoload.php";

$connection = new Login();
$connection->login();

$object = new Customers;
print_r($object->getCustomers());

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
?>