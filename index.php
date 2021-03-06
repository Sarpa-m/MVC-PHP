<?php
require_once __DIR__ . "/vendor/autoload.php";
//CARRAA AS VARIAVES DE AMBIENTE
WilliamCosta\DotEnv\Environment::load(__DIR__);


use App\Utils\View;
use App\Http\Middleware;
use App\Http\Router as HttpRouter;
use WilliamCosta\DatabaseManager\Database;
use App\Http\Middleware\Queue as MiddlewareQueue;

//DEFINE A URL BASE DO PROJETO
define("URL", getenv("URL"));

//INICIA O ROUTER
$obRouter = new HttpRouter(URL);

//DEFINE A URL ONDE O USÚARIO ESTA
define('URLc', $obRouter->getcurrentUrl());

//CONFIGURA AS CLASS DE ROTA
$obRouter->setRoutes([
    Router\pages::class,
    Router\admin::class,
    Router\api::class,
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
    "URL"  => URL,
    'URLc' => URLc
]);

//MAPEIA OS MIDDLEWARE
MiddlewareQueue::setMap([
    'mentenance'            => Middleware\Mentenance::class,
    'required-admin-logout' => Middleware\RequireAdminLogout::class,
    'required-admin-login'  => Middleware\RequireAdminlogin::class,
    'api'                   => Middleware\Api::class,
    'user-basic-auth'       => Middleware\UserBasicAuth::class,
    'JWT-auth'              => Middleware\JWTAuth::class,
    'cache'                 => Middleware\Cache::class,
]);

//DEFINE OS MIDDLEWARES PADOES PARA TODAS AS ROTAS
MiddlewareQueue::setDefault([
    'mentenance'
]);


//EXECUTA E INFRUME A ROTA
$obRouter->run()->sendResponse();
