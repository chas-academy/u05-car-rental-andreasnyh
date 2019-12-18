<?php

namespace Main\includes;

class Customers extends Login {
    public function getCustomers() {
        $statement = $this->login()->query("SELECT * FROM Customers");
        while ($row = $statement->fetchAll()) {

            return($row);
        }
    }
}