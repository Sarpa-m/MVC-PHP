<?php

namespace Router\admin;

use App\Controller\Admin as ControllerAdmin;
use App\Controller\Pages as ControllerPages;
use App\Http\Response;
use App\Http\Router;

class testimonies
{

    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = '/admin/testimonies';

    /**
     * 
     * @param  Router $obRouter
     * @param  string $preUlr
     * @return void
     */
    public static function init($obRouter, $preUlr = null)
    {

        //ROTA DE LISTAGEM DE DEPOIMETOS 
        $obRouter->get(self::$preUlr . '/', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\Testimony::getTestimonies($request));
            }
        ]);

        
        $obRouter->get(self::$preUlr . '/new', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\Testimony::getNewTestimonies($request));
            }
        ]);

        
        $obRouter->post(self::$preUlr . '/new', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\Testimony::setNewTestimonies($request));
            }
        ]);

        
        $obRouter->get(self::$preUlr . '/{id}/edit', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\Testimony::getEditTestimonies($request, $id));
            }
        ]);

        
        $obRouter->post(self::$preUlr . '/{id}/edit', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\Testimony::setEditTestimonies($request, $id));
            }
        ]);
        
        $obRouter->get(self::$preUlr . '/{id}/delete', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\Testimony::getDeleteTestimonies($request, $id));
            }
        ]);

        $obRouter->post(self::$preUlr . '/{id}/delete', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\Testimony::setDeleteTestimonies($request, $id));
            }
        ]);
    }
}
