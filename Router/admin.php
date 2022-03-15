<?php

namespace Router;

use App\Controller\Admin as ControllerAdmin;
use App\Http\Response;
use App\Http\Router;
use Router\admin as RouterAdmin;

class admin
{

    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = '/admin';

    /**
     * __construct
     *
     * @param  Router $obRouter
     * @param  string $preUlr
     * @return void
     */
    public static function  init($obRouter, $preUlr = null)
    {
        $obRouter->setRoutes([
            RouterAdmin\login::class,
            RouterAdmin\testimonies::class,
            RouterAdmin\user::class,
        ], $obRouter);

        $obRouter->get(self::$preUlr . '/', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\Home::getHome($request));
            }
        ]);
    }
}
