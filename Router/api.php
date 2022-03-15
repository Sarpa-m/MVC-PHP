<?php

namespace Router;

use App\Http\Response;
use App\Http\Router;
use App\Controller\Api\Api as ControllerApi;
use Router\api as RouterApi;

class api
{
    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = '/api';
    /**
     * __construct
     *
     * @param  Router $obRouter
     * @param  string $preUlr
     * @return void
     */
    public static function  init($obRouter)
    {
        $obRouter->setRoutes([
            RouterApi\v1\testimonies::class,
            RouterApi\v1\auth::class
        ], $obRouter);

        $obRouter->get(self::$preUlr . '/v1', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['api'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerApi::getDetails($request), 'application/json');
            }
        ]);

        $obRouter->get(self::$preUlr . '/v1/user/me', [
            //MIDDLEWARES DA ROT
            'middlewares' => ['api','JWT-auth'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerApi::getDetails($request), 'application/json');
            }
        ]);
    }
}
