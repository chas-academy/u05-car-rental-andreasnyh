<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* InputIndexView.twig */
class __TwigTemplate_8342f4d5504e2fea2019f2926b064eafe7c5ab6feba208f28212d59320159cc8 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<h1>Input Index</h1>
<p>
<form method=\"post\" action=\"/listIndex\" onsubmit=\"return validateIndex();\">
  Index: <input type=\"text\" name=\"index\" id=\"index\">
  <input type=\"submit\" value=\"Submit\">
</form>
<p>
<form method=\"post\" action=\"/\">
  <input type=\"submit\" value=\"Main Menu\">
</form>

<script>
   // Funktionen allDigits returnerar sant om texten innehåller minst en
   // siffra, och enbart siffror. Om texten alltså utgör ett icke-negativt
   // heltal.
   // Vi använder mönstermatchning för att avgöra om texten består av
   // minst en siffra, och enbart siffror.
   // ^ början av texten, \$ slutet av texten
   // [0-9] något av siffrorna 0-9
   // + ett eller flera, * noll eller flera, ? exakt ett
   function allDigits(text) { 
     return text.match(/^[0-9]+\$/) 
   } 

   // Funktionen validateIndex anropas då användaren klickar på Submit-
   // knappen. Om användaren angav ett korrekt värde i indatafältet
   // returneras sant.
   function validateIndex() {
     let index = document.getElementById(\"index\").value;
     
     if (allDigits(index)) {
       return true;
     }

     // Om användaren angav ett inkorrekt värde i indatafältet skrivs ett
     // felmeddelande ut, och falskt returneras.
     else {
       alert(\"\\\"\" + index + \"\\\" is not a valid index.\");
       return false;
     }
   }
</script>    
";
    }

    public function getTemplateName()
    {
        return "InputIndexView.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "InputIndexView.twig", "/home/vagrant/code/u05-car-rental-andreasnyh/src/Views/InputIndexView.twig");
    }
}
