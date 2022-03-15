<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Model\Entity\User;

use Firebase\JWT\JWT;

class auth
{
    /**
     * Método responsavel por retornar o token JWT
     *
     * @param Request $request
     * @return array
     */
    public static function generateToken($request)
    {
        //POST VARS
        $postVars =  $request->getPostVars();

        //VALIDA OS CAMPOS
        if (!isset($postVars['email']) or !isset($postVars['senha'])) {
            throw new \Exception("os compos 'email' e 'senha' são obrigatorios!", 400);
        }

        //BUSCA USUARIO PELO EMAIL
        $obUser = User::getUserByEmail($postVars['email']);

        //VERIFICA A INTANCIA E A SENHA
        if ((!$obUser instanceof User || !password_verify($postVars['senha'], $obUser->senha))) {
            throw new \Exception("email ou senha estão incoretos!", 400);
        }

        //PAYLOAD
        $payload = [
            'email' => $obUser->email,
        ];

        return ['token' => JWT::encode($payload, getenv('JWT_KEY'), "HS256")];
    }
}
