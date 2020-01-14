<?php

namespace Main\models;

use Main\exceptions\NotFoundException;
use Main\models\CustomersModel;
use PDO;
use PDOException;

class HistoryModel extends AbstractModel {

    public function getHistory(){

        $historyDB = $this->db->query("SELECT * FROM History");
        $carDB = new CarsModel($this->db);
        $customerDB = new CustomersModel($this->db);

        $historyArray = [];
        foreach ($historyDB as $historyFromDB) {
            $registration = htmlspecialchars($historyFromDB["registrationHistory"]);
            $renter = htmlspecialchars($historyFromDB["renterHistory"]);

            $rentStart = htmlspecialchars($historyFromDB["rentStartHistory"]);
            $returnTime = htmlspecialchars($historyFromDB["returnTimeHistory"]);

            $rentStartDate = date_create($rentStart);
            $returnTimeDate = date_create($returnTime);

            $dateDiff = date_diff($rentStartDate, $returnTimeDate);
            $rentedDays = $dateDiff->days;

            if ($rentedDays == 0){
                $rentedDays = 1;
            }

            $historyRow = ["registration" => $registration,
                           "renter" => $renter,
                           "rentedDays" => $rentedDays,
                           "rentStart" => $rentStart,
                           "returnTime" => $returnTime,
                           "car" => $carDB->getCar($this->db->quote($registration)),
                           "customer" => $customerDB->getCustomer($this->db->quote($renter))
            ];

            $historyArray[] = $historyRow;
        }
        #var_dump($historyArray);
        return $historyArray;
    }

    public function rentCar($registration, $SSN) {
        #$rentQuery = "INSERT INTO Rents(registration, renter, rentStartTime) " .
         #            "VALUES (:registration, :SSN, CURRENT_TIMESTAMP)";

        $rentQuery = <<<SQL
            UPDATE Cars SET renter = :SSN,
                            rentStart = CURRENT_TIMESTAMP
            WHERE registration = :registration;
SQL;


        $statement = $this->db->prepare($rentQuery);
        $statement->execute(["registration" => $registration, "SSN" => $SSN]);

        if(!$statement) die();
    }

    public function returnCar($registration, $renter, $rentStartTime) {
    # ADD RENTED CAR TO HISTORY
        $addToHistoryQuery = <<<SQL
        INSERT INTO History(registrationHistory, renterHistory, rentStartHistory, returnTimeHistory)
        VALUES (:registration, :renter, :rentStartTime, CURRENT_TIMESTAMP);
SQL;

        $date = new \DateTime();
        $returnTimeHistory = $date->getTimestamp();
        $returnTimeHistory = date('Y-m-d H:i:s',$returnTimeHistory);
        #var_dump($returnTimeHistory);
        $addToHistoryStatement = $this->db->prepare($addToHistoryQuery);
        $addToHistoryParams = ["registration" => $registration, "renter" => $renter,
            "rentStartTime" => $rentStartTime];
        #var_dump($addToHistoryParams);
        try {
            $addToHistoryStatement->execute($addToHistoryParams);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "Duplicate entry, you can´t return a car twice!";
            }
        }
        if(!$addToHistoryStatement) die();

    # RETURN CAR TO POOL

        $returnQuery = <<<SQL
        -- DELETE FROM Cars WHERE registration = :registration;
        UPDATE Cars SET renter = NULL,
                        rentStart = NULL
        WHERE registration = :registration;
SQL;

        $returnStatement = $this->db->prepare($returnQuery);

       # $historyParams = ["registrationHistory" => $registration, "renterHistory" => $renter, "rentStartHistory" => $rentStartTime];
       # $historyStatement->execute($historyParams);

        $returnParams = ["registration" => $registration];

        try {
            $returnStatement->execute($returnParams);
        } catch (PDOException $e){}

        return $returnTimeHistory;
    }

    public function getCarHistoryData($registration, $rentStartHistory)
    {
        #var_dump($registration);
        #var_dump($rentStartHistory);
        $carHistoryQuery = <<<SQL
            SELECT * FROM History WHERE registrationHistory = :registration AND rentStartHistory = :rentStartHistory;
SQL;
        $carHistoryStatement = $this->db->prepare($carHistoryQuery);
        if (!$carHistoryQuery) die($this->db->errorInfo());

        $carHistoryStatement->execute(["registration" => $registration, "rentStartHistory" => $rentStartHistory]);
        #$carHistory = ;
        #var_dump($carHistoryStatement->fetch());
        return $carHistoryStatement->fetch();
    }

}
