<?php
  namespace Main\Models ;
  
  class Model {
    private $personArray;
    
    // Konstruktorn initierar medlemsvariabeln $personArray med fem personer.
    public function __construct() {
      $adam = ["name" => "Adam Bertilsson", "address" => "Stora gatan 1",
               "phone" => "0123456789"];
      $bertil = ["name" => "Bertil Ceasarsson", "address" => "Stora gatan 2",
                 "phone" => "0234567890"];
      $ceasar = ["name" => "Ceasar Davidsson", "address" => "Stora gatan 3",
                 "phone" => "0234567890"];
      $david = ["name" => "David Eriksson", "address" => "Stora gatan 4",
                "phone" => "0345678901"];
      $erik = ["name" => "Erik Filipsson", "address" => "Stora gatan 5",
               "phone" => "0456789012"];      
      $this->personArray = [$adam, $bertil, $ceasar, $david, $erik];
    }

    // Metoden getAll returnerar hela medlemsvariabeln $personArray.
    public function getAll() {
      return $this->personArray;
    }

    // Metoden getIndex returnerar personen med det givna indexet.
    public function getIndex($index) {
      if ($index < count($this->personArray)) {
        return $this->personArray[$index];
      }

      // Om inte indexet ryms i arrayen, returneras null.
      else {
        return null;
      }
    }
  }
?>