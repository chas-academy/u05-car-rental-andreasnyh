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

    public function rentCar(){
        $historyModel = new HistoryModel($this->db);
        $form = $this->request->getForm();
        #var_dump($form);
        $registration = $form["registration"];
        $SSN = $form["SSN"];

        $rented = ["registration" => $registration, "SSN" => $SSN];

        $historyModel->rentCar($registration, $SSN);

        return $this->render("CarRented.twig", $rented);
    }

    public function returnCar(){
        $customersModel = new CustomersModel($this->db);
        $carModel = new CarsModel($this->db);
        $customerList = $customersModel->getCustomers();
        $carList = $carModel->getCars();
        $makesList = $carModel->getMakes();

        $carsAndCustomers = ["customerList" => $customerList, "carList" => $carList, "makesList" => $makesList];

        return $this->render("ReturnCar.twig", $carsAndCustomers);
    }

    public function carReturned() {
        $form = $this->request->getForm();
        $form = explode("|", $form["returnedCar"]);
        $registration = $form[0];
        $renter = intval($form[1]);
        $rentStartTime = strtotime($form[2]);
        $rentStartTime = date('Y-m-d H:i:s',$rentStartTime);
        #2020-01-03 13:10:02
        $model = new HistoryModel($this->db);
       # $model->returnCar($registration, $renter, $rentStartTime);

        $carReturned = [
            "registration" => $registration,
            "renter" => $renter,
            "rentStartTime" => $rentStartTime
        ];
        var_dump($rentStartTime);
        $model->returnCar($registration,$renter,$rentStartTime);

        return $this->render("CarEdited.twig", $carReturned);
    }
}