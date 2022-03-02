<?php
require_once __DIR__ . "/vendor/autoload.php";
//CARRAA AS VARIAVES DE AMBIENTE
WilliamCosta\DotEnv\Environment::load(__DIR__);

use App\Http\Router;
use App\Http\Middleware;
use App\Http\Middleware\Queue as MiddlewareQueue;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Database;




//DEFINE A URL BASE DO PROJETO
define("URL", getenv("URL"));

//INICIA O ROUTER
$obRouter = new Router(URL);

//CONFIGURA AS CLASS DE ROTA
$obRouter->setRoutes([
    Router\pages::class,
    Router\admin::class,
], $obRouter);

//CONFIGURA O BANCO DE DADOS
Database::config(
    getenv("DB_HOST"),
    getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_PORT")
);

//DEFINE O VALOR PADÃO DAS VARIAVES DA VIEW
View::init([
    "URL" => URL,
    'URLc' => $obRouter->getcurrentUrl()
]);

//MAPEIA OS MIDDLEWARE
MiddlewareQueue::setMap([
    'mentenance' => Middleware\Mentenance::class
]);

//DEFINE OS MIDDLEWARES PADOES PARA TODAS AS ROTAS
MiddlewareQueue::setDefault([
    'mentenance'
]);

/* echo '<pre>';
print_r($obRouter);
echo '</pre>';
exit; */

//EXECUTA E INFRUME A ROTA
$obRouter->run()->sendResponse();
