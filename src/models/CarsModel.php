<?php

namespace Main\models;

use Main\exceptions\NotFoundException;
use Main\utils\DependencyInjector;
use PDOException;


class CarsModel extends AbstractModel {

    public function getCars() {
        $carsDB = $this->db->query("SELECT * FROM Cars");
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
            $renter = htmlspecialchars($carFromDB["renter"]);
            $rentStart = htmlspecialchars($carFromDB["rentStart"]);
/*
            $historyQuery = "SELECT * FROM Cars WHERE renter = $renter";
            $histStatement = $this->db->prepare($historyQuery);
            #$histResult = $histStatement->execute(["registration" => $reg]);
            #if (!$histResult) die($this->db->errorInfo());

            $historyRows = $histStatement->fetchAll();

            $history = [];
            foreach ($historyRows as $historyRow) {
                $SSN = htmlspecialchars($historyRow["renter"]);
                $start = htmlspecialchars($historyRow["rentStart"]);
        #var_dump($SSN);

                $history = ["renter" => $SSN, "rentStart" => $start];
            }
*/
            #var_dump($history);
            #if (isset($history["renter"])) {
            #$renter = $history["renter"] ?? "";
            #$rentStart = $history["rentStart"] ?? "";
            #}
            $car = ["reg" => $reg, "make" => $make, "model" => $model,
                    "color" => $color, "year" => $year, "cost" => $cost, "renter" => $renter, "rentStart" => $rentStart];
    #var_dump($car);
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

    public function getCar($registration)
    {
        #var_dump($registration);
        $carDB = $this->db->query("SELECT * FROM Cars WHERE registration = $registration");

        $car = $carDB->fetch();
        #var_dump($car);
        return $car;
    }

    public function getMakes()
    {
        $makesDB = $this->db->query("SELECT * FROM Makes");
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
        $colorsDB = $this->db->query("SELECT * FROM Colors");
        // Traverse through the result of the select call, row-by-row
        $colorsArray = [];
        foreach ($colorsDB as $colorsFromDB) {
            $color = htmlspecialchars($colorsFromDB["color"]);
            $colors = ["color" => $color];
            $colorsArray[] = $colors;
        }
        return $colorsArray;
    }

    public function addCar($registration,$year, $cost, $make, $model, $color, $renter, $rentStart){
        $query = "INSERT INTO Cars(registration, year, cost, make, model, color, renter, rentStart) " .
            "VALUES (:registration, :year, :cost, :make, :model, :color, :renter, :rentStart)";

        $registration = strtoupper($registration);
        $cost = str_replace(",",".", $cost);
        $statement = $this->db->prepare($query);
        $params = ["registration" => $registration, "year" => $year, "cost" => $cost,
            "make" => $make, "model" => $model, "color" => $color, "renter" => $renter, "rentStart" => $rentStart];

        try {
            $statement->execute($params);
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "Duplicate entry, you can´t add a car twice!";
            }
        }


        if(!$statement) die();
    }

    public function editCar($registration, $yearNew, $costNew, $makeNew, $modelNew, $colorNew){

        $yearNew = htmlspecialchars($yearNew);
        $costNew = htmlspecialchars($costNew);
        $makeNew = htmlspecialchars($makeNew);
        $modelNew = htmlspecialchars($modelNew);
        $colorNew = htmlspecialchars($colorNew);

        $query = "UPDATE Cars SET year = :year ," .
            "year = :year ," .
            "cost = :cost ," .
            "make = :make ," .
            "model = :model ," .
            "color = :color " .
            "WHERE registration = :registration";

        $statement = $this->db->prepare($query);
        $car = ["registration" => $registration, "year" => $yearNew, "cost" => $costNew,
            "make" => $makeNew, "model" => $modelNew, "color" => $colorNew];

        $result = $statement->execute($car);
        if (!$result) die($this->db->errorInfo());
    }

    public function removeCar($registration) {
        $query = "DELETE FROM Cars WHERE registration = :registration";
        $statement = $this->db->prepare($query);
        $car = ["registration" => $registration];
        $result = $statement->execute($car);
        if (!$result) die($this->db->errorInfo());
    }
}