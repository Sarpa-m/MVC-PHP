<?php

use App\Controller\Pages\Home;
use App\Http\Rauter;
use App\Http\Response;
use App\Utils\View;

define("URL", getenv("URL"));

require_once __DIR__ . "/vendor/autoload.php";

//define o valor padrão das variaves da view
View::init([
    "URL" => URL
]);
//nicia o rauter
//$obRauter = new Rauter(URL);

// inclui as rotas
require_once __DIR__ . "/router/pages.php";
require_once __DIR__ . "/router/admin.php";


//inprime o Response da Rota
$obRauter->run()->sendResponse();
