<?php

namespace Main\models;

use Main\exceptions\NotFoundException;
use Main\models\CustomersModel;
use PDO;
use PDOException;

class HistoryModel extends AbstractModel {

    public function getHistory(){

        $historyDB = $this->db->query("SELECT * FROM History");
        $carsDB = $this->db->query("SELECT * FROM Cars");

        $historyArray = [];
        foreach ($historyDB as $historyFromDB) {
            $registration = htmlspecialchars($historyFromDB["registrationHistory"]);
            $renter = htmlspecialchars($historyFromDB["renterHistory"]);
            $customer = $this->db->query("SELECT * From Customers WHERE socialSecurityNumber = $renter");
            $customer = $customer->fetch();
            $rentStart = htmlspecialchars($historyFromDB["rentStartHistory"]);
            $returnTime = htmlspecialchars($historyFromDB["returnTimeHistory"]);

            $rentStartDate = date_create($rentStart);
            $returnTimeDate = date_create($returnTime);
            $result = date_diff($rentStartDate, $returnTimeDate);
            $result = $result->days;

            if ($result == 0){
                $result = 1;
            }
            /*
            foreach ($carsDB as $car) {
                if ($registration == htmlspecialchars($car["registration"])){
                    $reg = htmlspecialchars($car["registration"]);
                    $make = htmlspecialchars($car["make"]);
                    $model = htmlspecialchars($car["model"]);
                    $color = htmlspecialchars($car["color"]);
                    $year = htmlspecialchars($car["year"]);
                    $cost = htmlspecialchars($car["cost"]);
                    $carRow = ["registration" => $reg, "make" => $make, "model" => $model,
                        "color" => $color, "year" => $year, "cost" => $cost, "renter" => $renter];

                    #if ($car["renter"])
                    #var_dump($car);
                }
            }
            */

            #$car = $this->db->query("SELECT * From Cars WHERE registration = $registration");
            $carDB = new CarsModel($this->db);
            #$car = $carDB->getCar();
            $historyRow = ["registration" => $registration,
                            "renter" => $renter,
                            "rentedDays" => $result,
                            "rentStart" => $rentStart,
                            "returnTime" => $returnTime,
                            "car" => $carDB->getCar($registration),
                            "customer" => $customer
            ];

            $historyArray[] = $historyRow;
        }
        var_dump($historyArray);
        return $historyArray;
    }

    public function rentCar($registration, $SSN) {
        $rentQuery = "INSERT INTO Rents(registration, renter, rentStartTime) " .
                     "VALUES (:registration, :SSN, CURRENT_TIMESTAMP)";

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
        DELETE FROM Rents WHERE registration = :registration;
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
