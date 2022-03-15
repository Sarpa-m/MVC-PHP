<?php
namespace Router\api\v1;
use App\Controller\Api as ControllerApi;
use App\Http\Response;
use App\Http\Router;

class auth
{
    /**
     * Pre URL da rota
     *
     * @var string
     */
    private static $preUlr = '/api/v1/auth';
    /**
     * __construct
     *
     * @param  Router $obRouter
     * @param  string $preUlr
     * @return void
     */
    public static function  init($obRouter)
    {
        $obRouter->post(self::$preUlr . '/', [
            //MIDDLEWARES DA ROTA
            'middlewares' => ['api'],

            //CHAMAR CONTROLER
            function ($request) {
                return new Response(201, ControllerApi\Auth::generateToken($request), 'application/json');
            }
        ]);

    }
}
