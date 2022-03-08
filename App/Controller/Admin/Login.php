<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Model\Entity\User;
use App\Session\Admin\Login as AdminLogin;
use App\Utils\View;

class Login extends Page
{
    /**
     * getLogin
     *
     * @param  Request $request
     * @param  boolean $invalid
     * @return void
     */
    public static function getLogin($request, $invalid = false)
    {

        $content = [
            View::render("admin/pages/login", [
                'is-invalid' => (($invalid) ? 'is-invalid' : ''),
            ])

        ];

        return parent::getPage("Admin -> Login", $content);
    }

    /**
     * setLogin
     *
     * @param  Request $request
     * @return void
     */
    public static function setLogin($request)
    {
        //POST VARS

        $postVars = $request->getPostVars();

        $email = $postVars["email"] ?? "";
        $senha = $postVars['password'] ?? '';

        //BUSCA USUARIO PELO EMAIL
        $obUser = User::getUserByEmail($email);

        if (!$obUser instanceof User) {
            return self::getLogin($request, true);
        }

        if (!password_verify($senha, $obUser->senha)) {
            return self::getLogin($request, true);
        }

        //CRIA A SESSÃO DE LOGIN
        AdminLogin::login($obUser);

        //REDIRECIONA O USUARIO PARA A HOME DO ADMIN
        $request->getRouter()->redirect(URL . "/admin");
    }

    public static function setLogout($request)
    {
        //DESTROI A SESSÃO DE LOGIN
        AdminLogin::logout();

        //REDIRECIONA O USUARIO PARA A HOME DO ADMIN
        $request->getRouter()->redirect(URL . "/admin/login");
    }
}
