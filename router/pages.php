<?php

use App\Controller\Pages;
use App\Http\Router;
use App\Http\Response;

//inicia o router
$obRouter = new Router(URL);
//Rota de HOME
$obRouter->get('/', [

    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

$obRouter->get('/sobre', [

    function () {
        return new Response(200, Pages\Sobre::getSobre());
    }
]);


$obRouter->get('/depoimeto', [

    function ($request) {
        return new Response(200, Pages\Testimony::getTestimony($request));
    }
]);

$obRouter->post('/depoimeto', [

    function ($request) {
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);
