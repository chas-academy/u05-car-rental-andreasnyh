<?php

namespace Main\Models;

use Main\includes\Login;
use Main\utils\DependencyInjector;

abstract class AbstractModel {
    protected $login;

    public function __construct(Login $login) {
        $this->login = $login;
    }
/*
    protected $di;

    public function __construct(DependencyInjector $di) {
        $this->db = $di;
    }
    */
}