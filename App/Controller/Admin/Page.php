<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Page
{
    /**
     * Módulos diposnives no painel
     *
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL . '/admin'
        ], 'testimonies' => [
            'label' => 'Depoimentos',
            'link' => URL . '/admin/testimonies'
        ], 'users' => [
            'label' => 'Usuários',
            'link' => URL . '/admin/user'
        ],
    ];

    /**
     * Metodo responsavel por retornar o conteúdo (View) da nossa Pagina generica
     * @param string|array $content
     * @param string $title
     * @return string
     */
    public static function getPage($title, $content)
    {
        if (is_array($content)) {
            $content = implode("", $content);
        }

        return View::render('admin/page', [
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

        return View::render("admin/header", []);
    }

    /**
     * Metodo responsavel por retornar o footer da pagina
     *
     * @return strinbg
     */
    private static function getFooter()
    {

        return View::render("admin/footer", []);
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

    /**
     * Metodo responsavel por retornar uma mesagem de sucesso
     * @param  string $mensagem
     * @return string
     */
    public static function getAlertSuccess($mensagem)
    {

        return View::render("alert", [
            'tipo' => "success",
            'mensagem' => $mensagem
        ]);
    }

    /**
     * Metodo responsavel por retornar uma mesagem de erro
     * @param  string $mensagem
     * @return string
     */
    public static function getAlertError($mensagem)
    {

        return View::render("alert", [
            'tipo' => "danger",
            'mensagem' => $mensagem
        ]);
    }

    /**
     * Método responsavel por renderixza a view do painel com conteudos dinamicos 
     *
     * @param  string $title
     * @param  string $content
     * @param  string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule)
    {
        if (is_array($content)) {
            $content = implode("", $content);
        }

        //RENDERIZA A VIEW DO PANEL 
        $contentPanel = View::render("admin/panel", [
            'menu' => self::getMenu($currentModule),
            "content" => $content
        ]);

        //RETORNA A PAGINA RENDERIZADA 
        return self::getPage($title, $contentPanel);
    }

    /**
     * Método responsavel por renderizar a view do menu do painel 
     *
     * @param  string $currentModule
     * @return string
     */
    private static function getMenu($currentModule)
    {
        //LINKS DO MENU
        $links = '';

        //ITERA OS MÒDULOS
        foreach (self::$modules as $hash => $module) {
            $links .= View::render('admin\menu\link', [
                'link' => $module['link'],
                'label' => $module['label'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
            
        }

        //RETORNA A RENDERIZÇÃO DO MENU
        return View::render("admin/menu/box", [
            'links' => $links
        ]);
    }
}
