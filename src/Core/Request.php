<?php
  namespace Main\Core;

  class Request {
    private $path, $form;

    public function __construct() {
      $this->path = $_SERVER["REQUEST_URI"]; // path-delen av URL:en car.rental/____ex____
      $this->form = $_POST;                  // indata till formulären
    }

    public function getPath() {
      return $this->path;
    }

    public function getForm() {
      return $this->form;
    }
  }
?>