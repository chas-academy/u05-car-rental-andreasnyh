<?php
  namespace Main\Controllers;
  use Main\Models\Model;

  // Metoden listAll skapar ett objekt av klassen Model och anropar metoden
  // getAll, som ger hela personarrayen.
  class ListController {
    public function listAll($twig) {
      $model = new Model();
      $personArray = $model->getAll();

      // Personarrayen läggs i en map som skickas med twig:en. På så sätt
      // kan vi i twig-koden skriva ut personarrayen.
      $map = ["personArray" => $personArray];
      return $twig->load("ListAllView.twig")->render($map);
    }

    // Metoden listIndex tar förutom twig:en det index för personen vi söker.
    // Vi skapar ett objekt av klassen Model och anropar getIndex, vilket ger
    // oss den sökta person eller null om indexet var utanför arrayens
    // räckvidd.
    public function listIndex($twig, $index) {
      $model = new Model();
      $person = $model->getIndex($index);

      // Vi placerar indexet och personen i en map som vi skickar med i
      // Twig-anropet. Twig-anropet returnerar den färdiga HTML-koden, som
      // vi returtnerar tillbaka till routern och Index.php.
      $map = ["index" => $index, "person" => $person];
      return $twig->load("ListIndexView.twig")->render($map);
    }
  }
?>