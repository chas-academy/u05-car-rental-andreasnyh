<?php
  namespace Main\includes;

  use PDO;

  class Login
 {
      private $hostname;
      private $database;
      private $username;
      private $password;
      private $charset;

      public function login() {
        $this->hostname = "localhost";
        $this->database = "carRental";
        $this->username = "root";
        $this->password = "secret";
        $this->charset = "utf8mb4";



          try {
              $dsn = "mysql:host=".$this->hostname.";dbname=".$this->database.";charset=".$this->charset;
              $connection = new PDO($dsn, $this->username, $this->password);
              $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              return $connection;
          } catch (\PDOException $e){
                echo "connection failed: " . $e->getMessage();
          }

    }
  };

?>