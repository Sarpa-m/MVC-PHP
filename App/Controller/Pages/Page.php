<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{
    /**
     * Metodo responsavel por retornar o conteúdo (View) da nossa Pagina generica
     *
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('page', [
            "title" => $title,
            "content" => $content,
            "header" => self::getHeader(),
            "footer"=> self::getFooter(),


        ]);
    }

    /**
     * Metodo responsavel por retornar o header da pagina
     *
     * @return strinbg
     */
    private static function getHeader()
    {

        return View::render("header", []);
    }

       /**
     * Metodo responsavel por retornar o footer da pagina
     *
     * @return strinbg
     */
    private static function getFooter()
    {

        return View::render("footer", []);
    }
}
