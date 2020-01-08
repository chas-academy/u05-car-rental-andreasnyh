<?php

namespace Main\controllers;

use Main\models\CarsModel;
use Main\models\CustomersModel;
use Main\models\HistoryModel;

class HistoryController extends AbstractController {

    public function getCarsAndCustomers(){
        #$carsAndCustomersModel = new HistoryModel($this->db);
        #$carsAndCustomers = $carsAndCustomersModel->getCarsAndCustomers();
        $customersModel = new CustomersModel($this->db);
        $carModel = new CarsModel($this->db);
        $customerList = $customersModel->getCustomers();
        $carList = $carModel->getCars();
        $makesList = $carModel->getMakes();
        $colorsList = $carModel->getColors();

        $carsAndCustomers = ["customerList" => $customerList, "carList" => $carList, "makesList" => $makesList, "colorsList" => $colorsList];

        #$properties = ["carsAndCustomers" => $carsAndCustomers];
        return $this->render("RentCar.twig", $carsAndCustomers);
    }

}