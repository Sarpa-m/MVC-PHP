<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * Método responsavel por renderizar a view de listragem de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        //CONTEÚDO DA HOME
        $content = [
            View::render("admin/modules/testimonies/index", [
                'item' => self::getTestimonyItems($request, $obPagination),
                'pagination' => self::getPagination($request, $obPagination),
                'status' => self::getStatus($request),
            ]),

        ];

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Admin -> Depoimento", $content, 'testimonies');
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
        $items = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $qunatidadeTotal = EntityTestimony::getTestimonies(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;


        //PAGINA ATUAL
        $queryParams = $request->getQueyParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instacia de paginação 
        $obPagination = new Pagination($qunatidadeTotal, $paginaAtual, 3);

        //RESULTADO DA PÁGINA
        $resultis = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());

        //RETORNA OS ITEM
        while ($obTestimony = $resultis->fetchObject(EntityTestimony::class)) {
      
            $items .=  View::render('admin\modules\testimonies\item', [
                'id' => $obTestimony->id,
                'nome' => $obTestimony->nome,
                'texto' => $obTestimony->mensagem,
                'data' => date("d/m/Y H:i:s", strtotime($obTestimony->data)),

            ]);
        }

        //  RETORNO OS DEPOIMETOS
        return $items;
    }
    /**
     * Método responsavel por retornar o formulario de cadstro de um novo depoimento
     *
     * @param  Request $request
     * @return string
     */
    public static function getNewTestimonies($request)
    {
        //CONTEÚDO 
        $content = [
            View::render("admin/modules/testimonies/form", [
                'title' => 'Cadastrar depoimento',
                'nome' => '',
                'mensagem' => '',
                'status' => '',
            ]),

        ];

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Cadastrar -> Depoimento", $content, 'testimonies');
    }
    /**
     * Método responsavel por cadastrar um novo depoimento no banco 
     *
     * @param  Request $request
     * @return string
     */
    public static function setNewTestimonies($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTOS
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'] ?? '';
        $obTestimony->mensagem = $postVars['mensagem'] ?? '';
        $obTestimony->cadastrar();

        //REDIRECIO O USUARIO
        $request->getRouter()->redirect(URL . "/admin/testimonies/$obTestimony->id/edit?Status=created");
    }
    /**
     * Métood responsavel por retornar a mesagem de status
     *
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        //QUERY PARAMS
        $queyParams = $request->getQueyParams();

        //STATUS
        if (!isset($queyParams['Status'])) return "";

        //MESGEM DE STATUS
        switch ($queyParams['Status']) {
            case 'created':
                return self::getAlertSuccess("Depoimeto criado com sucesso");

                break;

            case 'updated':
                return self::getAlertSuccess("Depoimeto atualizado com sucesso");

                break;

            case 'delete':
                return self::getAlertSuccess("Depoimeto excluido com sucesso com sucesso");

                break;
            default:
                return "";

                break;
        }
    }
    /**
     * Método responsavel por retornar o formulário de edição de um depoimento 
     *
     * @param Request $request
     * @param string $id
     * @return string
     */
    public static function getEditTestimonies($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect(URL . '/admin/testimonies');
        }



        //CONTEÚDO 
        $content = [
            View::render("admin/modules/testimonies/form", [
                'title' => 'Editar depoimento',
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'status' => self::getStatus($request),
            ]),

        ];

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Editar -> Depoimento", $content, 'testimonies');
    }
    /**
     * Método responsavel por gravar a um depoimentos atualizado
     *
     * @param Request $request
     * @param string $id
     * @return string
     */
    public static function setEditTestimonies($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect(URL . '/admin/testimonies');
        }
        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTANCIA
        $obTestimony->nome = $postVars['nome'] ?? $obTestimony->nome;
        $obTestimony->mensagem = $postVars['mensagem'] ?? $obTestimony->mensagem;
        $obTestimony->atualizar();

        //REDIRECIO O USUARIO
        $request->getRouter()->redirect(URL . "/admin/testimonies/$obTestimony->id/edit?Status=updated");
    }
    /**
     * Método responsavel por retornar o formulário de exclusão de um depoimento 
     *
     * @param Request $request
     * @param string $id
     * @return string
     */
    public static function getDeleteTestimonies($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect(URL . '/admin/testimonies');
        }



        //CONTEÚDO 
        $content = [
            View::render("admin/modules/testimonies/delete", [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,

            ]),

        ];

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Excluir -> Depoimento", $content, 'testimonies');
    }
    /**
     * Método responsavel por excluir um depoimento 
     *
     * @param Request $request
     * @param string $id
     * @return string
     */
    public static function setDeleteTestimonies($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect(URL . '/admin/testimonies');
        }

        //EXCLUI DEPOIMETO O DEPOIMETO DO BANCO 
        $obTestimony->excluir();

        //REDIRECIO O USUARIO
        $request->getRouter()->redirect(URL . "/admin/testimonies?Status=delete");
    }
}
