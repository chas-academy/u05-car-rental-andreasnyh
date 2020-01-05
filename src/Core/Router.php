<?php
  namespace Main\core;

  use Main\controllers\ListController;
  use Main\controllers\InputController;
  use Main\controllers\MainController;

  // Routerns metod route tar ett object vardera av Request och Twig.
  class Router {
    public function route($request, $twig) {
      $path = $request->getPath();
      $form = $request->getForm();

      // Vi jämför path med de olika alternativen, skapar upp ett objekt av
      // rätt Controller-klass, och anropar rätt metod. Anropet returnerar
      // den färdiga HTML-koden, som vi returnerar tillbaka till filen
      // Index.php, och som därefter skrivs ut i Webläsaren.
      if ($path == "/listAll") {
        $controller = new ListController();
        return $controller->listAll($twig);
      }
      else if ($path == "/inputIndex") {
        $controller = new InputController();
        return $controller->inputIndex($twig);
      }

      // När vi skall skriva ut en specifik person behöver vi dess index,
      // som matades in av användaren via ett formulär. Det hämtar vi från
      // medlemsvariabeln $form.
      else if ($path == "/listIndex") {
        $controller = new ListController();
        $index = $form["index"];
        return $controller->listIndex($twig, $index);
      }

      // När vi först ladder filen Index.php kommer path vara endast ”/”, 
      // och då skall huvudmeny presenteras.
      else if ($path == "/") {
        $controller = new MainController();
        return $controller->mainMenu($twig);
      }

      // Om inget alternativ passar, returnerar vi endast ett felmeddelande. 
      else {
        return "Router Error!";
      }
    }
  }
?>