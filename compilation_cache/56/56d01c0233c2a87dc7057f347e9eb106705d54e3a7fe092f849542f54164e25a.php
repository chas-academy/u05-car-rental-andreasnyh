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

/* MainMenuView.twig */
class __TwigTemplate_6afdaaedab92c8742f82c8163e47ef8bb41d021f16cf0998a0c4fc3463501c6c extends Template
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
        echo "<h1>Main Menu</h1>
<p>
<form method=\"post\" action=\"/listAll\">
  <input type=\"submit\" value=\"List All\">
</form>
<p>
<form method=\"post\" action=\"/inputIndex\">
  <input type=\"submit\" value=\"List Index\">
</form>";
    }

    public function getTemplateName()
    {
        return "MainMenuView.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "MainMenuView.twig", "/home/vagrant/code/u05-car-rental-andreasnyh/src/Views/MainMenuView.twig");
    }
}
