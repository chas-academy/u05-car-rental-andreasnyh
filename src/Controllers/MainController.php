<?php
  namespace Main\Controllers;
  
  class MainController {
    public function mainMenu($twig) {
      return $twig->load("MainMenuView.twig")->render([]);
    }
  }
?>