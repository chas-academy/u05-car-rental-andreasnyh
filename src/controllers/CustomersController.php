<?php

namespace Main\controllers;

use Main\models\CustomersModel;

class CustomersController extends AbstractController {

    public function getCustomers() {
        $Model = new CustomersModel($this->db);
        $customers = $Model->getCustomers();
        $properties = ["customers" => $customers]; // Array of all customers sent to view
        return $this->render("CustomersView.twig", $properties);
    }

    public function getCustomer($renter) {
        $Model = new CustomersModel($this->db);
        return $Model->getCustomer($renter);
    }

    // Show form to add a new customer
    public function addCustomer() {
        return $this->render("AddCustomer.twig", []);
    }

    // Capture input from the input forms and send te data to the database
    public function customerAdded() {
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

        return $this->render("CustomerAdded.twig", $customer);
    }

    // Send existing data of a customer to the view
    public function editCustomer($socialSecurityNumber, $customerName, $address, $postalAddress, $phoneNumber) {
        $customer = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
            "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];
        return $this->render("EditCustomer.twig", $customer);
    }

    // Capture form-data and send new data to the database
    // Send both old and new data to the view to display changes
    public function customerEdited($socialSecurityNumber, $customerNameOld, $addressOld, $postalAddressOld, $phoneNumberOld) {
        $form = $this->request->getForm();
        $customerNameNew = $form["customerName"];
        $addressNew = $form["address"];
        $postalAddressNew = $form["postalAddress"];
        $phoneNumberNew = $form["phoneNumber"];

        $model = new CustomersModel($this->db);
        $model->editCustomer($socialSecurityNumber, $customerNameNew, $addressNew, $postalAddressNew, $phoneNumberNew);

        $customer = ["socialSecurityNumber" => $socialSecurityNumber,
            "customerNameOld" => $customerNameOld,
            "customerNameNew" => $customerNameNew,
            "addressOld" => $addressOld,
            "addressNew" => $addressNew,
            "postalAddressOld" => $postalAddressOld,
            "postalAddressNew" => $postalAddressNew,
            "phoneNumberOld" => $phoneNumberOld,
            "phoneNumberNew" => $phoneNumberNew];

        return $this->render("CustomerEdited.twig", $customer);
    }

    // Delete a particular customer from the database
    public function removeCustomer($socialSecurityNumber, $customerName) {
        $model = new CustomersModel($this->db);
        $model->removeCustomer($socialSecurityNumber);
        $properties = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName];
        return $this->render("CustomerRemoved.twig", $properties);
    }
}