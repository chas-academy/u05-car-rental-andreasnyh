<?php

namespace Main\models;

//use Bank\Domain\Bank;
#use Main\Exceptions\DbException;
use Main\exceptions\NotFoundException;
use Main\includes\Login;

class CarsModel extends AbstractModel {

    public function getCars() {
        $carsDB = $this->login->login()->query("SELECT * FROM Cars");
        $historyDB = $this->login->login()->query("SELECT * FROM History");
        #if (!$customers) die($this->login->errorInfo());

        // Traverse through the result of the select call, row-by-row
        $carArray = [];
        foreach ($carsDB as $carFromDB) {
            $reg = htmlspecialchars($carFromDB["registration"]);
            $make = htmlspecialchars($carFromDB["make"]);
            $model = htmlspecialchars($carFromDB["model"]);
            $color = htmlspecialchars($carFromDB["color"]);
            $year = htmlspecialchars($carFromDB["year"]);
            $cost = htmlspecialchars($carFromDB["cost"]);

            $car = ["reg" => $reg, "make" => $make, "model" => $model,
                    "color" => $color, "year" => $year, "cost" => $cost];

            $carArray[] = $car;
        }
/*
        $historyArray = [];
        foreach ($historyDB as $historyFromDB) {
            $reg = htmlspecialchars($historyFromDB["registration"]);
            $renter = htmlspecialchars($historyFromDB["renter"]);
            $rentStart = htmlspecialchars($historyFromDB["rentStart"]);
            $rentEnd = htmlspecialchars($historyFromDB["rentEnd"]);
            $days = htmlspecialchars($historyFromDB["days"]);
            $cost = htmlspecialchars($historyFromDB["cost"]);

            $history = ["reg" => $reg, "renter" => $renter, "rentStart" => $rentStart,
                "rentEnd" => $rentEnd, "days" => $days, "cost" => $cost];

            $historyArray[] = $history;
        }
*/
        return $carArray;
  }
}