<?php

namespace Main\models;

//use Bank\Domain\Bank;
#use Main\Exceptions\DbException;
use Main\exceptions\NotFoundException;
use Main\includes\Login;

class CustomersModel extends AbstractModel {

    public function getCustomers() {
        $customersDB = $this->login->login()->query("SELECT * FROM Customers");

        if (!$customersDB) die($this->login->login()->errorInfo());

        // Traverse through the result of the select call, row-by-row
        $customerArray = [];
        foreach ($customersDB as $customerFromDB) {
            $socialSecurityNumber = htmlspecialchars($customerFromDB["socialSecurityNumber"]);
            $customerName = htmlspecialchars($customerFromDB["customerName"]);
            $address = htmlspecialchars($customerFromDB["address"]);
            $postalAddress = htmlspecialchars($customerFromDB["postalAddress"]);
            $phoneNumber = htmlspecialchars($customerFromDB["phoneNumber"]);

            $historyQuery = "SELECT * FROM History WHERE renter = :renter";
            $histStatement = $this->login->login()->prepare($historyQuery);
            $histResult = $histStatement->execute(["renter" => $socialSecurityNumber]);
            if (!$histResult) die($this->login->login()->errorInfo());

            $historyRows = $histStatement->fetchAll();

            $history = [];
            foreach ($historyRows as $historyRow) {
                $SSN = htmlspecialchars($historyRow["renter"]);
                $start = htmlspecialchars($historyRow["rentStartTime"]);
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
  //(8205030789, "Glen Hysen", "Kungsportsavenyen 2", "411 38 Göteborg", "0709123432"),
  public function addCustomer($socialSecurityNumber,$customerName, $address, $postalAddress, $phoneNumber){
        $query = "INSERT INTO Customers(socialSecurityNumber, customerName, address, postalAddress, phoneNumber) " .
            "VALUES (:socialSecurityNumber, :customerName, :address, :postalAddress, :phoneNumber)";

        $statement = $this->login->login()->prepare($query);
        $statement->execute(["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName,
                            "address" => $address, "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber]);

        if(!$statement) die();
  }

  public function editCustomer($socialSecurityNumber,$customerNameNew, $addressNew, $postalAddressNew, $phoneNumberNew){
      #$customer = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
       #   "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];
        #var_dump($customer);
      #echo $socialSecurityNumber;
      $query = "UPDATE Customers SET customerName = :customerName ," .
                                    "address = :address ," .
                                    "postalAddress = :postalAddress ," .
                                    "phoneNumber = :phoneNumber " .
               "WHERE socialSecurityNumber = :socialSecurityNumber";

      $statement = $this->login->login()->prepare($query);
      $customer = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerNameNew, "address" => $addressNew,
                   "postalAddress" => $postalAddressNew, "phoneNumber" => $phoneNumberNew];

      $result = $statement->execute($customer);
      if (!$result) die($this->login->login()->errorInfo());
  }
}

/*
 *  public function editCustomer($customerNumber, $customerNewName) {
    $customersQuery = "UPDATE Customers SET customerName = :customerName " .
                      "WHERE customerNumber = :customerNumber";
    $customersStatement = $this->db->prepare($customersQuery);
    $customersParameters = ["customerName" => $customerNewName,
                            "customerNumber" => $customerNumber];
    $customersResult = $customersStatement->execute($customersParameters);
    if (!$customersResult) die($this->db->errorInfo()[2]);
  }*/