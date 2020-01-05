<?php

namespace Main\models;

//use Bank\Domain\Bank;
#use Main\Exceptions\DbException;
use Main\exceptions\NotFoundException;
use Main\includes\Login;

class CustomersModel extends AbstractModel {

    public function getCustomers() {
        $customersDB = $this->login->login()->query("SELECT * FROM Customers");

        #if (!$customers) die($this->login->errorInfo());

        // Traverse through the result of the select call, row-by-row
        $customerArray = [];
        foreach ($customersDB as $customerFromDB) {
            $socialSecurityNumber = htmlspecialchars($customerFromDB["socialSecurityNumber"]);
            $customerName = htmlspecialchars($customerFromDB["customerName"]);
            $address = htmlspecialchars($customerFromDB["address"]);
            $postalAddress = htmlspecialchars($customerFromDB["postalAddress"]);
            $phoneNumber = htmlspecialchars($customerFromDB["phoneNumber"]);


            $customer = ["SSN" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
                              "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];

            $customerArray[] = $customer;
        }
        #print_r($customerArray);
        return $customerArray;
  }
  //(8205030789, "Glen Hysen", "Kungsportsavenyen 2", "411 38 Göteborg", "0709123432"),
  public function addCustomer($socialSecurityNumber,$customerName, $address, $postalAddress, $phoneNumber){
        $query = "INSERT INTO Customers(socialSecurityNumber, customerName, address, postalAddress, phoneNumber) " .
            "VALUES (:socialSecurityNumber, :customerName, :address, :postalAddress, :phoneNumber)";

        $statement = $this->login->login()->prepare($query);
        $statement->execute(["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName,
                            "address" => $address, "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber]);

        if(!$statement) die();
  }
}