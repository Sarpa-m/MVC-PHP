<?php

namespace App\Controller\Pages;

use App\Model\Entity\Testimony as EntityTestimony;
use App\Utils\View;
use App\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * Metodo resposavel por retornar a view de Testimony
     *
     * @param Request $request
     * @return void
     */
    public static function getTestimony($request)
    {

        $content =  View::render('pages/testimony', [

         
            'item' => self::getTestimonyItems($request, $obPagination),
            'Pagination' => parent::getPagination($request, $obPagination)

        ]);
        return parent::getPage("Home > sarpa - MVC", $content);
    }

    /**
     * Médota desposavem por a rederização dos item de depoimetos
     * @param Request $request
     * @param Pagination &$obPagination
     * @return string
     */
    private static function getTestimonyItems($request,&$obPagination)
    {

        //DEPOIMETOS
        $items = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $qunatidadeTotal = EntityTestimony::getTestimonies(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueyParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instacia de paginação 
        $obPagination = new Pagination($qunatidadeTotal,$paginaAtual,3);



        $resultis = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());

        //RETORNA OS DEPOIMENTOS
        while ($obTestimony = $resultis->fetchObject(EntityTestimony::class)) {

            $items .=  View::render('pages/testimony/item', [
                'nome' => $obTestimony->nome,
                'mesagem' => $obTestimony->mensagem,
                'data' => date("d/m/Y H:i:s", strtotime($obTestimony->data)),

            ]);
        }
        //  RETORNO OS DEPOIMETOS
        return $items;
    }



    /**
     * Método responsavel por cadastrar um depoimentos
     *
     * @param Request $request
     * @return void
     */
    public static function insertTestimony($request)
    {

        //DADOS DO POST
        $postVars = $request->getPostVars();

        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['depoimeto'];
        $obTestimony->cadastrar();

        //Retarna a pagina de listagem de depoimetos 
        return self::getTestimony($request);
    }
}
