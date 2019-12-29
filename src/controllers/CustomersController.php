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
        return $this->render("AddCustomer.twig",[]);
    }
}