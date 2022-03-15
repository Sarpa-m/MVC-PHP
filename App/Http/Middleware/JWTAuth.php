<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Model\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
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

        //VALIDA O ACESSO VIA JWT
        $this->auth($request);

        //EXCUTA O PROXIMO Middleware   
        return $next($request);
    }
    /**
     * Métoodo responsavel por validar o acceso via JWT
     *
     * @param Request $request
     * @return void
     */
    private function auth($request)
    {
        //VERIFICA O  USUARIO RECEBIDO
        if ($obUser = $this->getJWTAuthUser($request)) {
            $request->user = $obUser;
            return true;
        }

        throw new \Exception('acesso negado', 403);
    }
    /**
     * Método responsavel por retornar uma intancia de usuario autenticado 
     * @param Request $request
     *
     * @return void
     */
    private function getJWTAuthUser($request)
    {

        //HEARDERS
        $header = $request->getHeaders();

        // [Authorization] => Bearer
        //TOKEN PURO EM JWT
        $jwt = isset($header['Authorization']) ? str_replace('Bearer ', '', $header['Authorization']) : '';

        try {
            //DECODE
            $decode = (array)JWT::decode($jwt, new Key(getenv('JWT_KEY'), 'HS256'));
        } catch (\Exception $e) {
            throw new \Exception('Token invalido', 1);
            
        }

        //EMAIL
        $email = $decode["email"] ?? '';

        $obUser = User::getUserByEmail($email);

        if (!$obUser instanceof User) {

            return false;
        }

        return $obUser;
    }
}
