<?php
  namespace Main\Controllers;
  
  class InputController {
    public function inputIndex($twig) {
      return $twig->load("InputIndexView.twig")->render([]);
    }
  }
?>