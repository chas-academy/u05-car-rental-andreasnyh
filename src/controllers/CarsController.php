<?php

namespace Main\controllers;

use Main\models\CarsModel;

class CarsController extends AbstractController {

    public function getCars(){
        $Model = new CarsModel($this->db);
        $cars = $Model->getCars();
        $properties = ["cars" => $cars];
        return $this->render("CarsView.twig", $properties);
    }

    public function addCar() {
        return $this->render("AddCar.twig", []);
    }

    public function carAdded(){
        $carModel = new CarsModel($this->db);
        $form = $this->request->getForm();

        $registration = $form["registration"];
        $year = $form["year"];
        $cost = $form["cost"];
        $make = $form["model"];
        $model = $form["make"];
        $color = $form["color"];
        $renter = NULL;

        $car = ["registration" => $registration, "year" => $year, "cost" => $cost,
            "make" => $make, "model" => $model, "color" => $color, "renter" => $renter];

        $carModel->addCar($registration, $year, $cost, $make, $model, $color, $renter);

        return $this->render("CarAdded.twig", $car);
    }
}