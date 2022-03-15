<?php
namespace App\Http\Middleware;
use App\Http\Request;
class Api
{

    /**
     * Método responsavel por executar o Middleware
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        //AUTERA O COINTENT TAYP PATA JSON
        $request->getRouter()->setContentType('application/json');

        //EXCUTA O PROXIMO Middleware   
        return $next($request);
    }
}
