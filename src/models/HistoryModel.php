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

    public function returnCar() {
        $rentQuery = "Select * from History";

        $statement = $this->login->login()->prepare($rentQuery);
        $statement->execute();

        if(!$statement) die();
    }
}