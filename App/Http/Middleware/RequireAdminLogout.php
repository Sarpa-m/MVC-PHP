<?php

namespace App\Http\Middleware;

use App\Session\Admin\Login as SessionAdminLogin;
use App\Http\Request;


class RequireAdminLogout
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

        if (SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect(URL . '/admin');
        }
        //CONTINUA A EXECUÇÃO
        return $next($request);
    }
}
