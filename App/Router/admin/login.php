<?php

namespace App\Router\admin;

use App\Controller\Admin as ControllerAdmin;
use App\Controller\Pages as ControllerPages;
use App\Http\Response;
use App\Http\Router;

class login
{

    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = '/admin';

    /**
     * 
     * @param  Router $obRouter
     * @param  string $preUlr
     * @return void
     */
    public static function init($obRouter, $preUlr = null)
    {
     
        $obRouter->get(self::$preUlr . '/login', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-logout'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\Login::getLogin($request));
            }
        ]);

        $obRouter->post(self::$preUlr . '/login', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-logout'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\Login::setLogin($request));
            }
        ]);

        $obRouter->get(self::$preUlr . '/logout', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\Login::setLogout($request));
            }
        ]);
    }
}
