<?php

namespace Main\models;

use PDOException;

class HistoryModel extends AbstractModel {

    // Display all history of rents
    public function getHistory(){

        $historyDB = $this->db->query("SELECT * FROM History");
        $carDB = new CarsModel($this->db);
        $customerDB = new CustomersModel($this->db);

        $historyArray = [];
        // Loop each row from History table
        foreach ($historyDB as $historyFromDB) {
            // Save variables for each loop
            $registration = htmlspecialchars($historyFromDB["registrationHistory"]);
            $renter = htmlspecialchars($historyFromDB["renterHistory"]);
            $rentStart = htmlspecialchars($historyFromDB["rentStartHistory"]);
            $returnTime = htmlspecialchars($historyFromDB["returnTimeHistory"]);

            // Turn rentStart and returnTime from string into proper date-type
            $rentStartDate = date_create($rentStart);
            $returnTimeDate = date_create($returnTime);

            // Gen an array of data of the differences in time between start and return
            $dateDiff = date_diff($rentStartDate, $returnTimeDate);

            // Save each returned datatype
            $rentedDays = $dateDiff->days;
            $rentedHours = $dateDiff->h;
            $rentedMins = $dateDiff->i;
            $rentedSecs = $dateDiff->s;

            if ($rentedDays == 0 && $rentedHours == 0 && $rentedMins == 0 && $rentedSecs == 0){
                $rentedDays = 0; // If there is no diff between the two times => rented days = 0
            } elseif ($rentedDays == 0 && ($rentedHours != 0 || $rentedMins != 0 || $rentedSecs != 0)){
                $rentedDays = 1; // If rentedDays = 0 And any of the other values is not 0 => rentedDays = 1
            } elseif ($rentedDays != 0 && ($rentedHours != 0 || $rentedMins != 0 || $rentedSecs != 0)){
                $rentedDays++; // If rentedDays is not 0 And any of the other is not 0 => add a day
            } else {
                $rentedDays = $dateDiff->days;
            }

            // Save all data of one rent
            $historyRow = ["registration" => $registration,
                           "renter" => $renter,
                           "rentedDays" => $rentedDays,
                           "rentStart" => $rentStart,
                           "returnTime" => $returnTime,
                           "car" => $carDB->getCar($this->db->quote($registration)), // get all information about rented car
                           "customer" => $customerDB->getCustomer($this->db->quote($renter)) // same with the customer
            ];

            // Push the data to array
            $historyArray[] = $historyRow;
        }
        return $historyArray; // Sent to view
    }

    // Connect a car with the customer who rents it
    public function rentCar($registration, $SSN) {

        // Query to start renting a car
        // Set who and WHEN(timestamp) someone starts renting a particular car
        $rentQuery = <<<SQL
            UPDATE Cars SET renter = :SSN, rentStart = CURRENT_TIMESTAMP
            WHERE registration = :registration;
SQL;

        $statement = $this->db->prepare($rentQuery);
        if(!$statement) die();

        $statement->execute(["registration" => $registration, "SSN" => $SSN]);
    }

    // Return rented car
    public function returnCar($registration, $renter, $rentStart) {
        // Add it to History and make it possible to rent the car again
        $addToHistoryQuery = <<<SQL
        INSERT INTO History(registrationHistory, renterHistory, rentStartHistory, returnTimeHistory)
        VALUES (:registration, :renter, :rentStartTime, CURRENT_TIMESTAMP);
SQL;

        $date = new \DateTime();
        $returnTimeHistory = $date->getTimestamp();
        $returnTimeHistory = date('Y-m-d H:i:s',$returnTimeHistory);

        $addToHistoryStatement = $this->db->prepare($addToHistoryQuery);
        // Parameters to be inserted into History table. ReturnTime is in the query.
        $addToHistoryParams = ["registration" => $registration, "renter" => $renter,
            "rentStartTime" => $rentStart];

        try {
            $addToHistoryStatement->execute($addToHistoryParams);
        } catch (PDOException $e) {
            if ($e->errorInfo[1]) {
                echo "Duplicate entry, you can´t return a car twice!";
            }
        }

        // Update Car table with Null values
        $returnQuery = <<<SQL
        UPDATE Cars SET renter = NULL,
                        rentStart = NULL
        WHERE registration = :registration;
SQL;

        $returnStatement = $this->db->prepare($returnQuery);
        $returnParams = ["registration" => $registration];

        try {
            $returnStatement->execute($returnParams);
        } catch (PDOException $e){
            if ($e->errorInfo[1]) {
                echo "Duplicate entry, you can´t return a car twice!";
            }
        }
        return $returnTimeHistory;
    }

    // used by carReturned in the controller to get historydata of a specific car
    public function getCarHistoryData($registration, $rentStartHistory) {

        $carHistoryQuery = <<<SQL
            SELECT * FROM History WHERE registrationHistory = :registration 
                                    AND rentStartHistory = :rentStartHistory;
SQL;
        $carHistoryStatement = $this->db->prepare($carHistoryQuery);
        if (!$carHistoryQuery) die($this->db->errorInfo());

        $carHistoryStatement->execute(["registration" => $registration, "rentStartHistory" => $rentStartHistory]);

        return $carHistoryStatement->fetch();
    }

}
