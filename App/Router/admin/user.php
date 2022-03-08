<?php

namespace App\Router\admin;

use App\Controller\Admin as ControllerAdmin;
use App\Controller\Pages as ControllerPages;
use App\Http\Response;
use App\Http\Router;

class user
{

    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = '/admin/user';

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
                return new Response(200, ControllerAdmin\User::getUser($request));
            }
        ]);

        
        $obRouter->get(self::$preUlr . '/new', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\User::getNewUser($request));
            }
        ]);

        
        $obRouter->post(self::$preUlr . '/new', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(200, ControllerAdmin\User::setNewUser($request));
            }
        ]);

        
        $obRouter->get(self::$preUlr . '/{id}/edit', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\User::getEditUser($request, $id));
            }
        ]);

        
        $obRouter->post(self::$preUlr . '/{id}/edit', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\User::setEditUser($request, $id));
            }
        ]);
        
        $obRouter->get(self::$preUlr . '/{id}/delete', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\User::getDeleteUser($request, $id));
            }
        ]);

        $obRouter->post(self::$preUlr . '/{id}/delete', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['required-admin-login'],

            //CHAMAR CONTROLER
            function ($request, $id) {
                return new Response(200, ControllerAdmin\User::setDeleteUser($request, $id));
            }
        ]);
    }
}
