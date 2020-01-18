<?php
namespace Main\controllers;

use Main\core\Request;
use Main\utils\DependencyInjector;

abstract class AbstractController {
    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $di;

    // Set up connections to be used by the other controllers
    public function __construct(DependencyInjector $di, Request $request) {
        $this->request = $request;
        $this->di = $di;
        $this->db = $di->get("PDO"); // Database
        $this->view = $di->get("Twig"); // Views
        $this->config = $di->get("Config"); // configuration
    }

    // Render twig file with optional parameters
    protected function render(string $template, array $params): string {
        return $this->view->render($template, $params);
    }
}
