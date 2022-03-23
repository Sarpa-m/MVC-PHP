<?php

namespace Router\api\v1;

use App\Controller\Api as ControllerApi;
use App\Http\Response;
use App\Http\Router;

class testimonies
{
    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = '/api/v1';
    /**
     * __construct
     *
     * @param  Router $obRouter
     * @param  string $preUlr
     * @return void
     */
    public static function  init($obRouter)
    {
        $obRouter->get(self::$preUlr . '/testimonies', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['api','cache'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerApi\Testimony::getTestimonies($request), 'application/json');
            }
        ]);

        $obRouter->get(self::$preUlr . '/testimony/{id}', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['api'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerApi\Testimony::getTestimony($request, $id), 'application/json');
            }
        ]);

        $obRouter->post(self::$preUlr . '/testimony', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['api', 'user-basic-auth'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(201, ControllerApi\Testimony::setNewTestimony($request), 'application/json');
            }
        ]);

        $obRouter->put(self::$preUlr . '/testimony/{id}', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['api', 'user-basic-auth'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerApi\Testimony::setEditTestimony($request, $id), 'application/json');
            }
        ]);

        $obRouter->delete(self::$preUlr . '/testimony/{id}', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['api', 'user-basic-auth'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerApi\Testimony::setDeleteTestimony($request, $id), 'application/json');
            }
        ]);
    }
}
