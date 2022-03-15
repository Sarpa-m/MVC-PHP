<?php

namespace App\Http\Middleware;

use App\Model\Entity\User;

class UserBasicAuth
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

        //VALIDA O ACESSO VIA BASIC AUTH
        $this->basicAuth($request);

        //EXCUTA O PROXIMO Middleware   
        return $next($request);
    }
    /**
     * Métoodo responsavel por validar o acceso via basic auth
     *
     * @param Request $request
     * @return void
     */
    private function basicAuth($request)
    {
        //VERIFICA O  USUARIO RECEBIDO
        if ($obUser = $this->getBasicAuthUser()) {
            $request->user = $obUser;
            return true;
        }

        throw new \Exception('Usuario ou senha inválidos', 403);
    }
    /**
     * Método responsavel por retornar uma intancia de usuario autenticado 
     *
     * @return void
     */
    private function getBasicAuthUser()
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        $obUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);

        if (!$obUser instanceof User) {

            return false;
        }
        if (!password_verify($_SERVER['PHP_AUTH_PW'], $obUser->senha)) {

            return false;
        }

        return $obUser;
    }
}
