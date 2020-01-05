<?php

namespace Main\Models;

use Main\includes\Login;

abstract class AbstractModel {
    protected $login;

    public function __construct(Login $login) {
        $this->login = $login;
    }
}