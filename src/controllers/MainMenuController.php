<?php

namespace Main\controllers;

use Main\models\MainMenuModel;

class MainMenuController extends AbstractController {

    public function showMenu(){
        // Render Main Menu
        return $this->render("MainMenu.twig", []);
    }

}