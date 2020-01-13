<?php

namespace Main\controllers;

use Main\models\CarsModel;
use Main\models\MakesModel;

class CarsController extends AbstractController {

    public function getCars(){
        $Model = new CarsModel($this->db);
        $cars = $Model->getCars();
        $properties = ["cars" => $cars];
        return $this->render("CarsView.twig", $properties);
    }

    public function addCar() {
        $makesModel = new CarsModel($this->db);
        $makes = $makesModel->getMakes();
        $colors = $makesModel->getColors();
        $properties = ["make" => $makes, "color" => $colors];
        #var_dump($properties);
        return $this->render("AddCar.twig", $properties);
    }

    public function carAdded(){
        $carModel = new CarsModel($this->db);
        $form = $this->request->getForm();
        #var_dump($form);
        $registration = $form["registration"];
        $year = $form["year"];
        $cost = $form["cost"];
        $make = $form["make"];
        $model = $form["model"];
        $color = $form["color"];
        $renter = NULL;

        $car = ["registration" => $registration, "year" => $year, "cost" => $cost,
            "make" => $make, "model" => $model, "color" => $color, "renter" => $renter];

        $carModel->addCar($registration, $year, $cost, $make, $model, $color, $renter);

        return $this->render("CarAdded.twig", $car);
    }

    public function editCar($registration,$year, $cost, $make, $model, $color){
        $makesModel = new CarsModel($this->db);
        $makesList = $makesModel->getMakes();
        $colorsList = $makesModel->getColors();

        $car = ["registration" => $registration, "year" => $year, "cost" => $cost,
            "make" => $make, "model" => $model, "color" => $color, "makesList" => $makesList, "colorsList" => $colorsList];
        return $this->render("EditCar.twig", $car);
    }

    public function carEdited($registration, $yearOld, $costOld, $makeOld, $modelOld, $colorOld) {
        $form = $this->request->getForm();
        $yearNew = $form["year"];
        $costNew = $form["cost"];
        $makeNew = $form["make"] ?? $makeOld;
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

    public function removeCar($registration, $make) {
        $model = new CarsModel($this->db);
        $model->removeCar($registration, $make);
        $properties = ["registration" => $registration, "make" => $make];
        return $this->render("CarRemoved.twig", $properties);
    }
}