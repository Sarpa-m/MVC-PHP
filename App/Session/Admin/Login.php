<?php

namespace App\Session\Admin;

use App\Model\Entity\User;


class Login
{

    /**
     * Método responsavel por iniciar a sessção
     */
    private static function init()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_name('Sarpinha_top');
            session_start();
        }
    }

    /**
     * Método responsavel por criar o login do usuário
     * @param  User $obUser
     * @return boolean
     */
    public static function login($obUser)
    {

        //INICIA A SESSÃO
        self::init();

        $_SESSION['admin']['usuario'] = [

            "id" => $obUser->id,
            "nome" => $obUser->nome,
            "email" => $obUser->email,
            "timestamp" => time(),
        ];


        //SUCESSO
        return true;
    }

    /**
     * Método responsavel por verificar se o usuário esta logado
     * @return boolean
     */
    public static function isLogged()
    {
        //INICIA A SESSÃO
        self::init();

        if (isset($_SESSION['admin']['usuario']['id'])) {

            if ($_SESSION['admin']['usuario']['timestamp'] + (10 * 60) >= time()) {
                return true;
            }
            $obUser = User::getUserById($_SESSION['admin']['usuario']['id']);
            if ($obUser instanceof User) {
                $_SESSION['admin']['usuario']['timestamp'] = time();
                return true;
            }
        }
        self::logout();
        return false;
    }

    public static function logout()
    {
        //INICIA A SESSÃO
        self::init();

        //DESLOGA O USUARIO
        unset($_SESSION['admin']['usuario']);
    }
}
