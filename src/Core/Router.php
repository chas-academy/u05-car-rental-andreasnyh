<?php
  namespace Main\core;

  use Main\utils\DependencyInjector;

  class Router {
    private $di;
    private $routeMap;

    public function __construct(DependencyInjector $di) {
        $this->di = $di;
        $json = file_get_contents(__DIR__ . "/../config/routes.json"); // get all the different routes
        $this->routeMap = json_decode($json, true);
    }

    public function route(Request $request): string {
        // request == path, method(get/post), parameters/form-data
        $path = $request->getPath();

        foreach ($this->routeMap as $route => $info) {
            $map = [];
            // if a parameter is not set, set it to Null
            $params = isset($info["params"]) ? $info["params"] : null;

            if ($this->match($route, $path, $params, $map)) {
                $controllerName = '\Main\controllers\\' .
                    $info["controller"] . "Controller";
                $controller = new $controllerName($this->di, $request);
                $methodName = $info["method"];
                return call_user_func_array([$controller, $methodName], $map);
            }
        }
    }

    private function match($route, $path, $params, &$map)
    {
        // $routeArray: ["editCustomer", ":customerNumber", ":customerName"]
        // $pathArray ["editCustomer", "7", "Erik%20Dumas"]

        $routeArray = explode("/", $route);
        $pathArray = explode("/", $path);
        $routeSize = count($routeArray);
        $pathSize = count($pathArray);

        if ($routeSize === $pathSize) {
            for ($index = 0; $index < $routeSize; ++$index) {
                // $routeName: ":customerNumber"
                // $pathName: "7"
                $routeName = $routeArray[$index];
                $pathName = $pathArray[$index];

                if ((strlen($routeName) > 0) && $routeName[0] === ":") {
                    // $key: "customerNumber"
                    // $value: "7"
                    $key = substr($routeName, 1);
                    $value = $pathName;

                    // "customerNumber": "number",
                    if (($params != null) && isset($params[$key]) &&
                        !$this->typeMatch($value, $params[$key])) {
                        return false;
                    }

                    // $map["customerNumber"] = "7";
                    // $map["customerName"] = "Erik Dumas";
                    $map[$key] = urldecode($value); // "%20" => " ", urlcode: " " => "%20"
                } else if ($routeName !== $pathName) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    // $value: "7"
    // $type: "number"
    private function typeMatch($value, $type)
    {
        switch ($type) {
            case "number":
                return preg_match('/^[0-9]+$/', $value);

            case "string":
                return preg_match('/^[%a-zA-Z0-9]+$/', $value);
        }
        return true;
    }
}
