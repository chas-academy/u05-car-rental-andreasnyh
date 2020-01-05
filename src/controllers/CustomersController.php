<?php

namespace Main\controllers;

use Main\models\CustomersModel;

class CustomersController extends AbstractController {

    public function getCustomers(){
        $Model = new CustomersModel($this->db);
        $customers = $Model->getCustomers();
        $properties = ["customers" => $customers];
        return $this->render("CustomersView.twig", $properties);
    }

    public function addCustomer() {
        return $this->render("AddCustomer.twig", []);
    }

    public function customerAdded(){
        $model = new CustomersModel($this->db);
        $form = $this->request->getForm();

        $socialSecurityNumber = $form["socialSecurityNumber"];
        $customerName = $form["customerName"];
        $address = $form["address"];
        $postalAddress = $form["postalAddress"];
        $phoneNumber = $form["phoneNumber"];

        $customer = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
                    "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];

        $model->addCustomer($socialSecurityNumber, $customerName, $address, $postalAddress, $phoneNumber);
        print_r($customer);
        return $this->render("CustomerAdded.twig", $customer);
    }
}