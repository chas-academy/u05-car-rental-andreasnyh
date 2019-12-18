<?php
  namespace Main\Core;

  class Login
  {
    function login()
    {
      $hostname = "localhost";
      $database = "carRental";
      $username = "root";
      $password = "secret";

      // We establish a connection toe the database, we need to send the host (localhost),
      // database (Bank), user id (root), and password (secret).

      $connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
      if (!$connection) die($connection->errorInfo()[2]);
      return $connection;
    }
  };

/*
try {
$dbh = new PDO('mysql:host=localhost;dbname=carRental', $username, $pass);
foreach($dbh->query('SELECT * from Customers') as $row) {
print_r($row);
}
$dbh = null;
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
*/
?>