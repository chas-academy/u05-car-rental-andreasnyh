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
}