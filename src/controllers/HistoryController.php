<?php

namespace Main\controllers;

use Main\models\CarsModel;
use Main\models\CustomersModel;
use Main\models\HistoryModel;

class HistoryController extends AbstractController {

    public function getHistory(){
        $historyModel = new HistoryModel($this->db);
        $customersModel = new CustomersModel($this->db);
        $carModel = new CarsModel($this->db);

        $history = $historyModel->getHistory();
        #$customer = $customersModel->getCustomer($history[0]["renter"]);
     /*   foreach ($history as $row){
            $customer = $customersModel->getCustomer($history[count($row)]["renter"]);
            $properties = ["history" => $history, "customer" => $customer];
        }*/
        $properties = ["history" => $history];
        #echo "controller properties";
        #var_dump($history[0]["registration"]);
        #$car = $carModel->getCar($registration);
        #var_dump($properties);
        return $this->render("HistoryView.twig", $properties);
    }

    public function getCarsAndCustomers(){
        $customersModel = new CustomersModel($this->db);
        $carModel = new CarsModel($this->db);
        $customerList = $customersModel->getCustomers();
        $carList = $carModel->getCars();
        $makesList = $carModel->getMakes();
        $colorsList = $carModel->getColors();

        $carsAndCustomers = ["customerList" => $customerList, "carList" => $carList, "makesList" => $makesList, "colorsList" => $colorsList];

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
        $rentStartTimeString = $form[2];
        $rentStartTime = strtotime($form[2]);
        $rentStartTime = date('Y-m-d H:i:s',$rentStartTime);

        $historyModel = new HistoryModel($this->db);
        $historyModel->returnCar($registration,$renter,$rentStartTime);

        $customerModel = new CustomersModel($this->db);
        #$customer = $customerModel->getCustomer($renter);

/*        $carReturned = [
            "registration" => $registration,
            "renter" => $renter,
            "rentStartTime" => $rentStartTime,
            "customer" => $customerModel->getCustomer($renter)
        ];*/

        $carReturned = [
            "car" => $historyModel->getCarHistoryData($registration,$rentStartTimeString),
            "customer" => $customerModel->getCustomer($renter)
        ];

        #var_dump($carReturned);
        return $this->render("CarReturned.twig", $carReturned);
    }

    public function getCarHistoryData($registration, $rentStartHistory){
        $carHistoryModel = new HistoryModel($this->db);
        return $carHistoryModel->getCarHistoryData($registration, $rentStartHistory);
    }
}