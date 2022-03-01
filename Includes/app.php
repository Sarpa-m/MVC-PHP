<?php

use App\Utils\View;
use WilliamCosta\DatabaseManager\Database;
use WilliamCosta\DotEnv\Environment;



Environment::load(__DIR__ . "/..");


define("URL", getenv("URL"));


Database::config(
    getenv("DB_HOST"),
    getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_PORT")
);



//define o valor padrão das variaves da view
View::init([
    "URL" => URL
]);
