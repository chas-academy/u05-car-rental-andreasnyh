<?php

namespace Main\models;

//use Bank\Domain\Bank;
#use Main\Exceptions\DbException;
use Main\exceptions\NotFoundException;
use Main\includes\Login;

class MainMenuModel extends AbstractModel {

    public function getCustomers() {
        $customers = $this->login->login()->query("SELECT * FROM Customers");

        // Traverse through the result of the select call, row-by-row
        foreach ($customers as $customer) {
            $customerName = htmlspecialchars($customer["customerName"]);
            $phoneNumber = htmlspecialchars($customer["phoneNumber"]);
            echo $customerName . " " . $phoneNumber . "<br>";
        }
  }
}