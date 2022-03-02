<?php

namespace App\Http\Router;

use App\Controller\Admin as ControllerAdmin;
use App\Controller\Pages as ControllerPages;
use App\Http\Response;
use App\Http\Router;

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
        $obRouter->get(self::$preUlr . '/', [
            //MIDDLEWARES DA ROTA
            'middlewares' => [],
            //FUNÇÃO ANONIMA PARA CHAMAR CONTROLER

            function ($request) {
                return new Response(200, ControllerAdmin\Home::getHome());
            }
        ]);

        $obRouter->get(self::$preUlr . '/login', [
            //MIDDLEWARES DA ROTA
            'middlewares' => [],
            //FUNÇÃO ANONIMA PARA CHAMAR CONTROLER

            function ($request) {
                return new Response(200, ControllerAdmin\Login::getLogin());
            }
        ]);
    }
}
