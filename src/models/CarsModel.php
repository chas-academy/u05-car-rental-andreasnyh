<?php

namespace Main\models;

//use Bank\Domain\Bank;
#use Main\Exceptions\DbException;
use Main\exceptions\NotFoundException;
use Main\includes\Login;

class CarsModel extends AbstractModel {

    public function getCars() {
        $carsDB = $this->login->login()->query("SELECT * FROM Cars");
        #$historyDB = $this->login->login()->query("SELECT * FROM History");
        #if (!$customers) die($this->login->errorInfo());

        // Traverse through the result of the select call, row-by-row
        $carArray = [];
        $histArray = [];
        foreach ($carsDB as $carFromDB) {
            $reg = htmlspecialchars($carFromDB["registration"]);
            $make = htmlspecialchars($carFromDB["make"]);
            $model = htmlspecialchars($carFromDB["model"]);
            $color = htmlspecialchars($carFromDB["color"]);
            $year = htmlspecialchars($carFromDB["year"]);
            $cost = htmlspecialchars($carFromDB["cost"]);

            $historyQuery = "SELECT * FROM History WHERE registration = :registration";
            $histStatement = $this->login->login()->prepare($historyQuery);
            $histResult = $histStatement->execute(["registration" => $reg]);
            if (!$histResult) die($this->login->login()->errorInfo());

            $historyRows = $histStatement->fetchAll();

            $history = [];
            foreach ($historyRows as $historyRow) {
                $SSN = htmlspecialchars($historyRow["renter"]);
                $start = htmlspecialchars($historyRow["rentStartTime"]);
        #var_dump($SSN);

                $history = ["renter" => $SSN, "rentStartTime" => $start];
            }

            #var_dump($history);
            #if (isset($history["renter"])) {
            $renter = $history["renter"] ?? "";
            $rentStartTime = $history["rentStartTime"] ?? "";
            #}
            $car = ["reg" => $reg, "make" => $make, "model" => $model,
                    "color" => $color, "year" => $year, "cost" => $cost, "renter" => $renter, "rentStartTime" => $rentStartTime];

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

    public function getMakes()
    {
        $makesDB = $this->login->login()->query("SELECT * FROM Makes");
        // Traverse through the result of the select call, row-by-row
        $makesArray = [];
        foreach ($makesDB as $makesFromDB) {
            $make = htmlspecialchars($makesFromDB["make"]);
            $makes = ["make" => $make];
            $makesArray[] = $makes;
        }
            return $makesArray;
    }

    public function getColors()
    {
        $colorsDB = $this->login->login()->query("SELECT * FROM Colors");
        // Traverse through the result of the select call, row-by-row
        $colorsArray = [];
        foreach ($colorsDB as $colorsFromDB) {
            $color = htmlspecialchars($colorsFromDB["color"]);
            $colors = ["color" => $color];
            $colorsArray[] = $colors;
        }
        return $colorsArray;
    }

    public function addCar($registration,$year, $cost, $make, $model, $color, $renter){
        $query = "INSERT INTO Cars(registration, year, cost, make, model, color, renter) " .
            "VALUES (:registration, :year, :cost, :make, :model, :color, :renter)";

        $statement = $this->login->login()->prepare($query);
        $statement->execute(["registration" => $registration, "year" => $year, "cost" => $cost,
            "make" => $make, "model" => $model, "color" => $color, "renter" => $renter]);

        if(!$statement) die();
    }
}