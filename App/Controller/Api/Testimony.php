<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Model\Entity\Testimony as EntityTestimony;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Api
{
    /**
     * Método responsavel por retornar os depoimetos cadastrados
     *
     * @param Request $request
     * @return array
     */
    public static function getTestimonies($request)
    {

        return [
            'depoimetos' => self::getTestimonyItems($request, $obPagination),
            'paginacao'  => parent::getPagination($request, $obPagination),
        ];
    }
    /**
     * Médota desposavem por a rederização dos item de depoimetos
     * @param Request $request
     * @param Pagination &$obPagination
     * @return string
     */
    private static function getTestimonyItems($request, &$obPagination)
    {

        //DEPOIMETOS
        $items = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $qunatidadeTotal = EntityTestimony::getTestimonies(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueyParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instacia de paginação 
        $obPagination = new Pagination($qunatidadeTotal, $paginaAtual, 3);



        $resultis = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());

        //RETORNA OS DEPOIMENTOS
        while ($obTestimony = $resultis->fetchObject(EntityTestimony::class)) {

            $items[] = [
                'id' => (int)$obTestimony->id,
                'nome'    => $obTestimony->nome,
                'mesagem' => $obTestimony->mensagem,
                'data'    => $obTestimony->data,
            ];
        }
        //  RETORNO OS DEPOIMETOS
        return $items;
    }
    /**
     * Método responsaver por retotnar um depoimeto apartir do ID
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public static function getTestimony($request, $id)
    {
        if (!is_numeric($id)) {
            throw new \Exception("O id '$id' não é valido", 400);
        }

        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA SÉ EXISTE
        if (!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("Depoimeto $id não foi encontrodo", 404);
        }

        return  [
            'id' => (int)$obTestimony->id,
            'nome'    => $obTestimony->nome,
            'mesagem' => $obTestimony->mensagem,
            'data'    => $obTestimony->data,
        ];
    }
    /**
     * Método responsavel por cadastrar um novo depoimento
     * @param Request $request 
     */
    public static function setNewTestimony($request)
    {
        //PostVars
        $postVars = $request->getPostVars();

        //VALIDA CANPOS OBRIGATORIOS
        if (!isset($postVars['nome']) || !isset($postVars['mensagem'])) {
            throw new \Exception("os compos 'nome' e 'mensagem' são obrigatorios!", 400);
        }

        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        return [
            'sucesso' => [
                'id' => (int)$obTestimony->id,
                'nome'    => $obTestimony->nome,
                'mesagem' => $obTestimony->mensagem,
                'data'    => $obTestimony->data,
            ]
        ];
    }
    /**
     * Método responsavel por atualizar um depoimento
     * @param Request $request setEditTestimony($request, $id)
     */
    public static function setEditTestimony($request, $id)
    {
        //PostVars
        $postVars = $request->getPostVars();

        //VALIDA CANPOS OBRIGATORIOS
        if (!(isset($postVars['nome']) || isset($postVars['mensagem']))) {
            throw new \Exception("os compos 'nome' ou 'mensagem' são obrigatorios!", 400);
        }

        //BUSCA O DEPOIMETO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("Depoimeto $id não foi encontrodo", 404);
        }


        //ATUALIA O DEPOIMETO
        $obTestimony->nome     = $postVars['nome'] ?? $obTestimony->nome;
        $obTestimony->mensagem = $postVars['mensagem'] ?? $obTestimony->mensagem;
        $obTestimony->cadastrar();

        return [
            'sucesso' => [
                'id' => (int)$obTestimony->id,
                'nome'    => $obTestimony->nome,
                'mesagem' => $obTestimony->mensagem,
                'data'    => $obTestimony->data,
            ]
        ];
    }
    /**
     * Método responsavel por EXCLUIR um depoimento
     * @param Request $request setEditTestimony($request, $id)
     */
    public static function setDeleteTestimony($request, $id)
    {
        //BUSCA O DEPOIMETO NO BANCO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("Depoimeto $id não foi encontrodo", 404);
        }

        //APAGA O DEPOIMETO
        $obTestimony->excluir();

        return [
            'sucesso' => true
        ];
    }
}
