<?php
require_once __DIR__ . "/vendor/autoload.php";

require_once __DIR__ . "/Includes/app.php";






//nicia o router
//$obRouter = new Router(URL);

// inclui as rotas
require_once __DIR__ . "/router/pages.php";
require_once __DIR__ . "/router/admin.php";


//inprime o Response da Rota
$obRouter->run()->sendResponse();
