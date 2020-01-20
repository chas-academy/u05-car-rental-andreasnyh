<?php

namespace Main\models;

use PDOException;


class CarsModel extends AbstractModel {

    // Get an array of all cars
    public function getCars() {

        $carsDB = $this->db->query("SELECT * FROM Cars");

        // Array to save each individual car in
        $carArray = [];
        // Loop through the results from DB query
        foreach ($carsDB as $carFromDB) {
            $reg = htmlspecialchars($carFromDB["registration"]);
            $make = htmlspecialchars($carFromDB["make"]);
            $model = htmlspecialchars($carFromDB["model"]);
            $color = htmlspecialchars($carFromDB["color"]);
            $year = htmlspecialchars($carFromDB["year"]);
            $cost = htmlspecialchars($carFromDB["cost"]);
            $renter = htmlspecialchars($carFromDB["renter"]);
            $rentStart = htmlspecialchars($carFromDB["rentStart"]);

            // Save variables from each loop as car
            $car = ["reg" => $reg,
                "make" => $make,
                "model" => $model,
                "color" => $color,
                "year" => $year,
                "cost" => $cost,
                "renter" => $renter,
                "rentStart" => $rentStart];

            // Push car into array of all Cars
            $carArray[] = $car;
        }
        return $carArray; // gets sent back to the controller to be sent to the view
  }
    // Get data of a particular car
    public function getCar($registration) {
        $carDB = $this->db->query("SELECT * FROM Cars WHERE registration = $registration");
        $car = $carDB->fetch();
        return $car;
    }

    // Get an array of all valid makes
    public function getMakes() {
        $makesDB = $this->db->query("SELECT * FROM Makes");

        $makesArray = [];
        // Same as with cars, Save each make from database in array
        foreach ($makesDB as $makesFromDB) {
            $make = htmlspecialchars($makesFromDB["make"]);
            $makes = ["make" => $make];
            $makesArray[] = $makes;
        }
            return $makesArray;
    }

    // Get an array of all valid colors
    public function getColors() {
        $colorsDB = $this->db->query("SELECT * FROM Colors");

        $colorsArray = [];
        foreach ($colorsDB as $colorsFromDB) {
            $color = htmlspecialchars($colorsFromDB["color"]);
            $colors = ["color" => $color];
            $colorsArray[] = $colors;
        }
        return $colorsArray;
    }

    // Insert new car data into database
    public function addCar($registration,$year, $cost, $make, $model, $color, $renter, $rentStart){
        $query = "INSERT INTO Cars(registration, year, cost, make, model, color, renter, rentStart) " .
            "VALUES (:registration, :year, :cost, :make, :model, :color, :renter, :rentStart)";

        $registration = strtoupper($registration); // Make registration letter uppercase...just in Case
        $cost = str_replace(",",".", $cost); // Replace ','s with '.'s

        $statement = $this->db->prepare($query);
        $params = ["registration" => $registration, "year" => $year, "cost" => $cost,
            "make" => $make, "model" => $model, "color" => $color, "renter" => $renter, "rentStart" => $rentStart];

        try {
            $statement->execute($params);
        } catch (PDOException $e) {
            die($e->getMessage());
                #die("Duplicate entry, you can´t add a car twice!");
        }
    }

    // Send updated car data to the database
    public function editCar($registration, $yearNew, $costNew, $makeNew, $modelNew, $colorNew){

        $yearNew = htmlspecialchars($yearNew);
        $costNew = htmlspecialchars($costNew);
        $makeNew = htmlspecialchars($makeNew);
        $modelNew = htmlspecialchars($modelNew);
        $colorNew = htmlspecialchars($colorNew);

        $query = "UPDATE Cars SET " .
                "year = :year ," .
                "cost = :cost ," .
                "make = :make ," .
                "model = :model ," .
                "color = :color " .
                "WHERE registration = :registration";

        $statement = $this->db->prepare($query);
        $car = [
            "registration" => $registration,
            "year" => $yearNew,
            "cost" => $costNew,
            "make" => $makeNew,
            "model" => $modelNew,
            "color" => $colorNew
        ];

        $result = $statement->execute($car);
        if (!$result) die($this->db->errorInfo());
    }

    // Delete a particular car from the database
    public function removeCar($registration) {
        $query = "DELETE FROM Cars WHERE registration = :registration";
        $statement = $this->db->prepare($query);
        $car = ["registration" => $registration];
        $result = $statement->execute($car);
        if (!$result) die($this->db->errorInfo());
    }
}