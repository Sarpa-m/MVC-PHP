<?php

namespace App\Controller\Api;

use WilliamCosta\DatabaseManager\Pagination;
use App\Http\Request;

class Api
{
    /**
     * Método responsavel por retornar os detalhes da API
     *
     * @param Request $request
     * @return array
     */
    public static function getDetails($request)
    {

        return [
            'nome'   => 'Sarpa - MVC',
            'Versao' => 'v1.0.0',
            'autor'  => 'Maurício Sarpa',
            'email'  => 'mausarpa02@gmail.com',
        ];
    }
    /**
     * Método resposavele pro retornar a paginação 
     *
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */
    public static function getPagination($request, $obPagination)
    {
        //QUERY PARAMS
        $queryParams = $request->getQueyParams();

        //PÁGINA
        $pages = $obPagination->getPages();

        return [
            'paginaAtual'         => isset($queryParams["page"]) ? (int)$queryParams["page"] :1,
            "quantidadeDePaginas" => !empty($pages) ? count($pages) : 2,
        ];
    }

    
}
