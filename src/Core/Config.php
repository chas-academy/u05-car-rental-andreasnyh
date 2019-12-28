<?php

namespace Main\core;
use Main\exceptions\NotFoundException;

class Config {
    private $map;

    public function __construct() {
        $json = file_get_contents(__DIR__ . "/../config/app.json");
        $this->map = json_decode($json, true);
    }

    public function get($key) {
        if (isset($this->map[$key])) {
            return $this->map[$key];
        }
        
        throw (new NotFoundException("Key $key not in config."));
    }
}