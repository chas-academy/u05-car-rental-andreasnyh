<?php

namespace Main\models;

use Main\exceptions\NotFoundException;
use Main\includes\Login;
use Main\models\CustomersModel;
use MongoDB\BSON\Timestamp;

class HistoryModel extends AbstractModel {

    public function rentCar($registration, $SSN) {
        $rentQuery = "INSERT INTO Rents(registration, renter, rentStartTime) " .
                     "VALUES (:registration, :SSN, CURRENT_TIMESTAMP)";

        $statement = $this->login->login()->prepare($rentQuery);
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
        $addToHistoryStatement = $this->login->login()->prepare($addToHistoryQuery);
        $addToHistoryParams = ["registration" => $registration, "renter" => $renter,
            "rentStartTime" => $rentStartTime];
        #var_dump($addToHistoryParams);
        $addToHistoryStatement->execute($addToHistoryParams);

        if(!$addToHistoryStatement) die();

    # RETURN CAR TO POOL

        $returnQuery = <<<SQL
        DELETE FROM Rents WHERE registration = :registration;
SQL;

        $returnStatement = $this->login->login()->prepare($returnQuery);

       # $historyParams = ["registrationHistory" => $registration, "renterHistory" => $renter, "rentStartHistory" => $rentStartTime];
       # $historyStatement->execute($historyParams);

        $returnParams = ["registration" => $registration];

        $returnStatement->execute($returnParams);
        return $returnTimeHistory;
    }
}