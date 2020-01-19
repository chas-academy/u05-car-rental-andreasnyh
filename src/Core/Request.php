<?php
  namespace Main\core;

  class Request {
    private $path, $method, $form;

    public function __construct() {
        $pathArray = explode("?", $_SERVER["REQUEST_URI"]);
        $this->path = substr($pathArray[0],1);
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->form = array_merge($_POST, $_GET); // indata till formulären
    }

    public function getPath() {
      return $this->path;
    }

    public function getForm() {
      return $this->form;
    }
  }
?>