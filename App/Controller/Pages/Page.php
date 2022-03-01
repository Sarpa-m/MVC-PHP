<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

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
            "footer" => self::getFooter(),


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

    /**
     * Método responsavel por renderizar a layout de paginação
     *
     * @param  Request $request
     * @param  Pagination $obPagination
     * @return void
     */
    public static function getPagination($request, $obPagination)
    {
        //PAGINAS
        $pages = $obPagination->getPages();

        //VERIFICA A QUANTIDADE DE PAGINAS 
        if (count($pages) <= 1) {
            return '';
        }

        //LIMKS
        $links = "";

        //URL AUTAL SEM GETS
        $url = $request->getRouter()->getcurrentUrl();

        //GTES
        $queyParams = $request->getQueyParams();

        foreach ($pages as $page) {
            //ALTERA A PÁGINA
            $queyParams['page'] = $page['page'];

            //LINK
            $link = $url . '?' . http_build_query($queyParams);

            //VIEW
            $links .= View::render('pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => ($page['current'] == 1) ? 'active' : ''
            ]);
            
        }

       
        //REDENRIZA BOX DE PAGINAÇÃO

        return View::render('pagination/box', [
            'links' => $links
        ]);
    }
}
