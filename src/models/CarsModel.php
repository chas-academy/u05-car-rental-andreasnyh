<?php

namespace Main\models;

//use Bank\Domain\Bank;
#use Main\Exceptions\DbException;
use Main\exceptions\NotFoundException;
use Main\includes\Login;

class CarsModel extends AbstractModel {

    public function getCars() {
        $carsDB = $this->login->login()->query("SELECT * FROM Cars");

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
        return $carArray;
  }
}