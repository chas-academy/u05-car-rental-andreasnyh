<?php

namespace Main\models;

use Main\exceptions\NotFoundException;
use PDO;

class CustomersModel extends AbstractModel {

    public function getCustomers() {
        $customersDB = $this->db->query("SELECT * FROM Customers ORDER BY customerName");
        if (!$customersDB) die($this->db->errorInfo());

        // Array to save each customer in
        $customerArray = [];
        // Loop all customers and save their data in variables
        foreach ($customersDB as $customerFromDB) {
            $socialSecurityNumber = htmlspecialchars($customerFromDB["socialSecurityNumber"]);
            $customerName = htmlspecialchars($customerFromDB["customerName"]);
            $address = htmlspecialchars($customerFromDB["address"]);
            $postalAddress = htmlspecialchars($customerFromDB["postalAddress"]);
            $phoneNumber = htmlspecialchars($customerFromDB["phoneNumber"]);

            // Check if customer is renting a car currently
            $rentingQuery = "SELECT * FROM Cars WHERE renter = :renter";
            $rentingStatement = $this->db->prepare($rentingQuery);
            $rentResult = $rentingStatement->execute(["renter" => $socialSecurityNumber]);
            if (!$rentResult) die($this->db->errorInfo());

            // Fetch results from query
            $rentingRows = $rentingStatement->fetchAll();

            $renting = [];
            // Push SSN and Rent start time to the array if customer is renting a car
            foreach ($rentingRows as $renterRow) {
                $SSN = htmlspecialchars($renterRow["renter"]);
                $start = htmlspecialchars($renterRow["rentStart"]);

                $renting = ["renter" => $SSN, "rentStartTime" => $start];
            }

            // if $renting["renter] is not set default value to empty string
            $renter = $renting["renter"] ?? "";
            $rentStartTime = $renting["rentStartTime"] ?? "";

            $customer = ["SSN" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
                        "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber,
                        "renter" => $renter, "rentStartTime" => $rentStartTime];

            // Save individual customer to the array
            $customerArray[] = $customer;
        }
        return $customerArray;
  }

    public function getCustomer($renter)
    {
        $customerDB = $this->db->query("SELECT * FROM Customers WHERE socialSecurityNumber = $renter");
        $customer = $customerDB->fetch();

        if (!$customerDB) die($this->db->errorInfo());
        return $customer;
    }

  //(8205030789, "Glen Hysen", "Kungsportsavenyen 2", "411 38 Göteborg", "0709123432"),
  public function addCustomer($socialSecurityNumber,$customerName, $address, $postalAddress, $phoneNumber){
        $query = "INSERT INTO Customers(socialSecurityNumber, customerName, address, postalAddress, phoneNumber) " .
            "VALUES (:socialSecurityNumber, :customerName, :address, :postalAddress, :phoneNumber)";

        $statement = $this->db->prepare($query);
        $statement->execute(["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName,
                            "address" => $address, "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber]);

        if(!$statement) die();
  }

  public function editCustomer($socialSecurityNumber,$customerNameNew, $addressNew, $postalAddressNew, $phoneNumberNew){

      #$socialSecurityNumber = htmlspecialchars($socialSecurityNumber);
      $customerNameNew = htmlspecialchars($customerNameNew);
      $addressNew = htmlspecialchars($addressNew);
      $postalAddressNew = htmlspecialchars($postalAddressNew);
      $phoneNumberNew = htmlspecialchars($phoneNumberNew);

      $query = "UPDATE Customers SET customerName = :customerName ," .
                                    "address = :address ," .
                                    "postalAddress = :postalAddress ," .
                                    "phoneNumber = :phoneNumber " .
               "WHERE socialSecurityNumber = :socialSecurityNumber";

      $statement = $this->db->prepare($query);
      $customer = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerNameNew, "address" => $addressNew,
                   "postalAddress" => $postalAddressNew, "phoneNumber" => $phoneNumberNew];

      $result = $statement->execute($customer);
      if (!$result) die($this->db->errorInfo());
  }

  public function removeCustomer($socialSecurityNumber) {
      $customer = ["socialSecurityNumber" => $socialSecurityNumber];

      $historyQuery = "UPDATE History SET renterHistory = NULL WHERE renterHistory = $socialSecurityNumber";
      $historyStatement = $this->db->prepare($historyQuery);
      $historyResult = $historyStatement->execute($customer);

      $customerQuery = "DELETE FROM Customers WHERE socialSecurityNumber = :socialSecurityNumber";
      $statement = $this->db->prepare($customerQuery);
      $result = $statement->execute($customer);
      if (!$result) die($this->db->errorInfo());
    }

}
