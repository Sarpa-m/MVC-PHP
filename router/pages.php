<?php

use App\Controller\Pages;
use App\Http\Rauter;
use App\Http\Response;

//inicia o rauter
$obRauter = new Rauter(URL);
//Rota de HOME
$obRauter->get('/', [

    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

$obRauter->get('/sobre', [

    function () {
        return new Response(200, Pages\Sobre::getSobre());
    }
]);


$obRauter->get('/pagina/{idpagina}/{iu}', [

    function ($idpagina,$iu,) {
        return new Response(200, "oi $idpagina <hr> $iu");
    }
]);
