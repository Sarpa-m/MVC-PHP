<?php

namespace App\Router;


use App\Controller\Pages as ControllerPages;
use App\Http\Response;
use App\Http\Router;

class pages
{
    
    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = null;

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
            'middlewares' => [
                "mentenance"
            ],
            function ($request) {
                return new Response(200, ControllerPages\Home::getHome($request));
            }
        ]);

        $obRouter->get(self::$preUlr . '/sobre', [

            function ($request) {
                return new Response(200, ControllerPages\Sobre::getSobre(($request)));
            }
        ]);


        $obRouter->get(self::$preUlr . '/depoimeto', [

            function ($request) {
                return new Response(200, ControllerPages\Testimony::getTestimony($request));
            }
        ]);

        $obRouter->post(self::$preUlr . '/depoimeto', [

            function ($request) {
                return new Response(200, ControllerPages\Testimony::insertTestimony($request));
            }
        ]);
    }
}
