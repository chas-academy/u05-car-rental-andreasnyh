<?php

namespace Main\controllers;

use Main\models\CarsModel;
use Main\models\CustomersModel;
use Main\models\HistoryModel;

class HistoryController extends AbstractController {

    // Display all history of rents
    public function getHistory(){
        $historyModel = new HistoryModel($this->db);
        $history = $historyModel->getHistory();
        $properties = ["history" => $history]; // Data returned from the model

        return $this->render("HistoryView.twig", $properties);
    }

    // Function run to display Rent car view
    public function getCarsAndCustomers(){
        $customersModel = new CustomersModel($this->db);
        $customerList = $customersModel->getCustomers();

        $carModel = new CarsModel($this->db);
        $carList = $carModel->getCars();
        $makesList = $carModel->getMakes();
        $colorsList = $carModel->getColors();

        // All Customer, Cars, Makes and Colors
        $carsAndCustomers = ["customerList" => $customerList, "carList" => $carList, "makesList" => $makesList, "colorsList" => $colorsList];

        return $this->render("RentCar.twig", $carsAndCustomers);
    }

    public function rentCar(){
        $historyModel = new HistoryModel($this->db);

        // Get form-data from RentCar view and save registration and social security number
        $form = $this->request->getForm();
        $registration = $form["registration"];
        $SSN = $form["SSN"];

        $rented = ["registration" => $registration, "SSN" => $SSN];

        // Run rentCar function in the model with parameters registration and ssn
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
        $form = explode("|", $form["returnedCar"]); // Split values returned from view
        $registration = $form[0];
        $renter = intval($form[1]);
        $rentStartTimeString = $form[2];
        $rentStartTime = strtotime($form[2]);
        $rentStartTime = date('Y-m-d H:i:s',$rentStartTime);

        $historyModel = new HistoryModel($this->db);
        // Return the car with these parameters
        $historyModel->returnCar($registration,$renter,$rentStartTime);

        $customerModel = new CustomersModel($this->db);

        // Data sent to view
        $carReturned = [
            "car" => $historyModel->getCarHistoryData($registration,$rentStartTimeString),
            "customer" => $customerModel->getCustomer($renter)
        ];

        return $this->render("CarReturned.twig", $carReturned);
    }

    // return info about returned car to be sent to the view
    public function getCarHistoryData($registration, $rentStartHistory){
        $carHistoryModel = new HistoryModel($this->db);
        return $carHistoryModel->getCarHistoryData($registration, $rentStartHistory);
    }
}