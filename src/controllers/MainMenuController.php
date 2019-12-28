<?php

namespace Main\controllers;
//use Main\includes\Login;
use Main\models\MainMenuModel;

class MainMenuController extends AbstractController {

    public function customerList(){
        $Model = new MainMenuModel($this->db);
        $customers = $Model->getCustomers();
        $properties = ["customers" => $customers];
        return $this->render("MainMenu.twig", $properties);
    }
}