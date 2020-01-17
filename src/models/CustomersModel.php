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
        foreach ($customersDB as $customerFromDB) {
            $socialSecurityNumber = htmlspecialchars($customerFromDB["socialSecurityNumber"]);
            $customerName = htmlspecialchars($customerFromDB["customerName"]);
            $address = htmlspecialchars($customerFromDB["address"]);
            $postalAddress = htmlspecialchars($customerFromDB["postalAddress"]);
            $phoneNumber = htmlspecialchars($customerFromDB["phoneNumber"]);

            $historyQuery = "SELECT * FROM Cars WHERE renter = :renter";
            $histStatement = $this->db->prepare($historyQuery);
            $histResult = $histStatement->execute(["renter" => $socialSecurityNumber]);
            if (!$histResult) die($this->db->errorInfo());

            $historyRows = $histStatement->fetchAll();

            $history = [];
            foreach ($historyRows as $historyRow) {
                $SSN = htmlspecialchars($historyRow["renter"]);
                $start = htmlspecialchars($historyRow["rentStart"]);
                #var_dump($SSN);

                $history = ["renter" => $SSN, "rentStartTime" => $start];
            }

            $renter = $history["renter"] ?? "";
            $rentStartTime = $history["rentStartTime"] ?? "";

            $customer = ["SSN" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
                        "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber,
                        "renter" => $renter, "rentStartTime" => $rentStartTime];

            $customerArray[] = $customer;
        }
        #print_r($customerArray);
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
