<?php

namespace Main\controllers;

use Main\models\CarsModel;

class CarsController extends AbstractController {

    // Display all cars
    public function getCars(){
        $Model = new CarsModel($this->db);
        $cars = $Model->getCars();
        $properties = ["cars" => $cars]; //Array of all cars
        return $this->render("CarsView.twig", $properties);
    }

    // Get the data of one car
    public function getCar($registration){
        $Model = new CarsModel($this->db);
        return $Model->getCar($registration);
    }

    // Add new car form
    public function addCar() {
        $makesModel = new CarsModel($this->db);
        $makes = $makesModel->getMakes(); // List of all valid makes
        $colors = $makesModel->getColors(); // List of valid colors
        $properties = ["make" => $makes, "color" => $colors];
        return $this->render("AddCar.twig", $properties);
    }

    // Capture form-data and run addCar method in the model to insert it into the database
    public function carAdded(){
        $carModel = new CarsModel($this->db);
        $form = $this->request->getForm(); // get all form data as an array

        // Save the form data in variables
        $registration = $form["registration"];
        $year = $form["year"];
        $cost = $form["cost"];
        $cost = str_replace(",",".", $cost); // Replace ',' with '.' in cost if present
        $make = $form["make"];
        $model = $form["model"];
        $color = $form["color"];
        $renter = NULL;
        $rentStart = NULL;

        // Combine all data into a complete "car"
        $car = ["registration" => $registration, "year" => $year, "cost" => $cost,
            "make" => $make, "model" => $model, "color" => $color, "renter" => $renter, "rentStart" => $rentStart];

        // Call the addCar function with data input
        $carModel->addCar($registration, $year, $cost, $make, $model, $color, $renter, $rentStart);

        return $this->render("CarAdded.twig", $car);
    }

    // Send existing data of a car to the view
    public function editCar($registration,$year, $cost, $make, $model, $color){
        $carModel = new CarsModel($this->db);
        $makesList = $carModel->getMakes();
        $colorsList = $carModel->getColors();

        $car = ["registration" => $registration, "year" => $year, "cost" => $cost, "make" => $make,
            "model" => $model, "color" => $color, "makesList" => $makesList, "colorsList" => $colorsList];
        return $this->render("EditCar.twig", $car);
    }

    // Capture form-data and send new data to the database
    // Send both old and new data to the view to display changes
    public function carEdited($registration, $yearOld, $costOld, $makeOld, $modelOld, $colorOld) {
        $form = $this->request->getForm();
        $yearNew = $form["year"];
        $costNew = $form["cost"];
        $makeNew = $form["make"] ?? $makeOld; // if no new value use old value
        $modelNew = $form["model"];
        $colorNew = $form["color"] ?? $colorOld;

        $model = new CarsModel($this->db);
        $model->editCar($registration, $yearNew, $costNew, $makeNew, $modelNew, $colorNew);

        $car = [
            "registration" => $registration,
            "yearOld" => $yearOld,
            "yearNew" => $yearNew,
            "costOld" => $costOld,
            "costNew" => $costNew,
            "makeOld" => $makeOld,
            "makeNew" => $makeNew,
            "modelOld" => $modelOld,
            "modelNew" => $modelNew,
            "colorOld" => $colorOld,
            "colorNew" => $colorNew
        ];

        return $this->render("CarEdited.twig", $car);
    }

    // Delete a particular car from the database
    public function removeCar($registration, $make) {
        $model = new CarsModel($this->db);
        $model->removeCar($registration);
        $properties = ["registration" => $registration, "make" => $make];
        return $this->render("CarRemoved.twig", $properties);
    }
}
