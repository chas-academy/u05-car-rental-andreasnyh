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

    public function __construct(DependencyInjector $di, Request $request) {
        $this->request = $request;
        $this->di = $di;
        $this->db = $di->get("Database");
        #$this->log = $di->get("Logger");
        $this->view = $di->get("Twig");
        $this->config = $di->get("Config");
    }

    protected function render(string $template, array $params): string {
        #return $this->view->loadTemplate($template)->render($params);
        return $this->view->render($template, $params);
    }
}