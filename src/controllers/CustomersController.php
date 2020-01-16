<?php

namespace Main\controllers;

use Main\models\CustomersModel;

class CustomersController extends AbstractController
{

    public function getCustomers()
    {
        $Model = new CustomersModel($this->db);
        $customers = $Model->getCustomers();
        $properties = ["customers" => $customers];
        return $this->render("CustomersView.twig", $properties);
    }

    public function getCustomer($renter)
    {
        $Model = new CustomersModel($this->db);
        return $Model->getCustomer($renter);
    }

    public function addCustomer()
    {
        return $this->render("AddCustomer.twig", []);
    }

    public function customerAdded()
    {
        $model = new CustomersModel($this->db);
        $form = $this->request->getForm();

        $socialSecurityNumber = $form["socialSecurityNumber"];
        $socialSecurityNumber = $this->validateSSN($socialSecurityNumber);
        $customerName = $form["customerName"];
        $address = $form["address"];
        $postalAddress = $form["postalAddress"];
        $phoneNumber = $form["phoneNumber"];

        $customer = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
            "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];

        $model->addCustomer($socialSecurityNumber, $customerName, $address, $postalAddress, $phoneNumber);

        return $this->render("CustomerAdded.twig", $customer);
    }

    private function validateSSN($socialSecurityNumber)
    {
        ## Validate SSN
        $socialSecurityNumberPattern = "/\d\d[0-1]\d[0-3]\d\d\d\d\d/";


        if (preg_match($socialSecurityNumberPattern, $socialSecurityNumber)) {
            $ssnDigits = str_split($socialSecurityNumber);
            print_r($ssnDigits);
            $sum = 0;
            for ($i = 0; $i < 9; $i++) {
                if ($i % 2 == 0) {
                    $digitArray[] = $ssnDigits[$i] * 2;
                } else {
                    $digitArray[] = $ssnDigits[$i] * 1;
                }
            }
            $digitArrayString = (implode($digitArray));
            $digitArraySplit = str_split($digitArrayString);
            /*
            foreach ($digitArray as $digit){
                $digitArraySplit[] = str_split($digit);
                #var_dump($digitArraySplit);

            }*/
            foreach ($digitArraySplit as $number) {
                #var_dump($number);
                $sum += $number;
            }


#$digitArraySplit = explode('', $digitArray);
            $controllNumber = (10 - ($sum % 10) % 10);
            var_dump($controllNumber);
            var_dump($sum);
            var_dump($digitArraySplit);
#echo "match: " . $socialSecurityNumber;
            if ($ssnDigits[9] == $controllNumber) {
                echo $socialSecurityNumber . " Is a valid SSN";
                return $socialSecurityNumber;
            } else {
                echo "Invalid Social Security Number";
                xdebug_break();
            }
        } else {
            echo "Invalid Social Security Number";
            return $php_errormsg;
        }
## / Validate SSN
    }

    public function editCustomer($socialSecurityNumber, $customerName, $address, $postalAddress, $phoneNumber)
    {
        $customer = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName, "address" => $address,
            "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];
        return $this->render("EditCustomer.twig", $customer);
    }

    public function customerEdited($socialSecurityNumber, $customerNameOld, $addressOld, $postalAddressOld, $phoneNumberOld)
    {
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

    public function removeCustomer($socialSecurityNumber, $customerName)
    {
        $model = new CustomersModel($this->db);
        $model->removeCustomer($socialSecurityNumber, $customerName);
        $properties = ["socialSecurityNumber" => $socialSecurityNumber, "customerName" => $customerName];
        return $this->render("CustomerRemoved.twig", $properties);
    }
}