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

/* ListAllView.twig */
class __TwigTemplate_0dd80b81fc74eb0528a9bef6616c9d6cf49dbe2881538836dd09319bc0716a66 extends Template
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
        echo "<h1>List All</h1>
<p>
<ol>
  ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["personArray"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["person"]) {
            // line 5
            echo "    <li>
      <ul>
        <li>";
            // line 7
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["person"], "name", [], "any", false, false, false, 7), "html", null, true);
            echo "</li>
        <li>";
            // line 8
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["person"], "address", [], "any", false, false, false, 8), "html", null, true);
            echo "</li>
        <li>";
            // line 9
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["person"], "phone", [], "any", false, false, false, 9), "html", null, true);
            echo "</li>
      </ul>
    </li>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['person'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "</ol>
<p>
<form method=\"post\" action=\"/\">
  <input type=\"submit\" value=\"Main Menu\">
</form>  ";
    }

    public function getTemplateName()
    {
        return "ListAllView.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 13,  58 => 9,  54 => 8,  50 => 7,  46 => 5,  42 => 4,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "ListAllView.twig", "/home/vagrant/code/u05-car-rental-andreasnyh/src/Views/ListAllView.twig");
    }
}
