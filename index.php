<?php

use App\Controller\Pages\Home;

require_once __DIR__."/vendor/autoload.php";

$obResponse = new \App\Http\Response(300,"olá munto");

$obResponse->sendResponse();

echo Home::getHomo();


