<?php

namespace Main\includes;

class Customers extends Login {
    public function getCustomers() {
        $customers = $this->login()->query("SELECT * FROM Customers");

        // Traverse through the result of the select call, row-by-row
        foreach ($customers as $customer) {
            $customerName = htmlspecialchars($customer["customerName"]);
            $phoneNumber = htmlspecialchars($customer["phoneNumber"]);
            echo $customerName . " " . $phoneNumber . "<br>";
        }
    }

    public function findSinglePerson() {
        $name = "Frida Fridh";

        $statement = $this->login()->prepare("Select * from Customers where customerName=?");
        $statement->execute([$name]);

        if ($statement->rowCount()){
            foreach ($statement as $customer) {
                $customerName = htmlspecialchars($customer["customerName"]);
                echo $customerName . "<br>";
            }
        }
    }
};