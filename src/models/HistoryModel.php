<?php

namespace Main\models;

use Main\exceptions\NotFoundException;
use Main\includes\Login;
use Main\models\CustomersModel;

class HistoryModel extends AbstractModel {

    public function rentCar($registration, $SSN) {
        $rentQuery = "INSERT INTO History(registration, renter, rentStartTime) " .
                     "VALUES (:registration, :SSN, CURRENT_TIMESTAMP)";

        $statement = $this->login->login()->prepare($rentQuery);
        $statement->execute(["registration" => $registration, "SSN" => $SSN]);

        if(!$statement) die();
    }

    public function returnCar($registration, $renter, $rentStartTime) {
        $returnQuery = <<<SQL
        INSERT INTO History (registrationHistory, renterHistory, rentStartHistory, returnTimeHistory) VALUES (
            registrationHistory = :registration,
            renterHistory = :renter,
            rentStartHistory = :rentStartTime,
            returnTimeHistory = :returnTimeHistory 
        );
SQL;

        $statement = $this->login->login()->prepare($returnQuery);
        $params = ["registrationHistory" => $registration, "renterHistory" => $renter, "rentStartHistory" => $rentStartTime, "returnTimeHistory" => ];
        $statement->execute($params);

        if(!$statement) die();
    }
}