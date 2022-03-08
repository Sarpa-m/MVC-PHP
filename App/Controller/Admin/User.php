<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\User as EntityUser;
use WilliamCosta\DatabaseManager\Pagination;

class User extends Page
{
    /**
     * Método responsavel por renderizar a view de listragem de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getUser($request)
    {


        //CONTEÚDO DA HOME
        $content = [
            View::render("admin/modules/user/index", [
                'item' => self::getUserItems($request, $obPagination),
                'pagination' => self::getPagination($request, $obPagination),
                'status' => self::getStatus($request),
            ]),

        ];



        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Admin -> Depoimento", $content, 'user');
    }
    /**
     * Médota desposavem por a rederização dos item de depoimetos
     * @param Request $request
     * @param Pagination &$obPagination
     * @return string
     */
    private static function getUserItems($request, &$obPagination)
    {

        //DEPOIMETOS
        $items = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $qunatidadeTotal = EntityUser::getUsers(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;


        //PAGINA ATUAL
        $queryParams = $request->getQueyParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instacia de paginação 
        $obPagination = new Pagination($qunatidadeTotal, $paginaAtual, 3);

        //RESULTADO DA PÁGINA
        $resultis = EntityUser::getUsers(null, "id DESC", $obPagination->getLimit());



        //RETORNA OS ITEM
        while ($obUser = $resultis->fetchObject(EntityUser::class)) {

            $items .=  View::render('admin\modules\user\item', [
                'id' => $obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email,
            ]);
        }

        //  RETORNO OS DEPOIMETOS
        return $items;
    }
    /**
     * Método responsavel por retornar o formulario de cadstro de um novo Usúario
     *
     * @param  Request $request
     * @return string
     */
    public static function getNewUser($request)
    {
        //CONTEÚDO 
        $content = [
            View::render("admin/modules/user/form", [
                'title' => 'Cadastrar depoimento',
                'nome' => '',
                'email' => '',
                'status' => self::getStatus($request),
            ]),

        ];

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Cadastrar -> Depoimento", $content, 'users');
    }
    /**
     * Método responsavel por cadastrar um novo Usúario no banco 
     *
     * @param  Request $request
     * @return string
     */
    public static function setNewUser($request)
    {
        //POST VARS
        $postVars = $request->getPostVars();
        $obUser = EntityUser::getUserByEmail($postVars['email']);

        if ($obUser instanceof EntityUser) {
            $request->getRouter()->redirect(URL . "/admin/user/new?Status=duplicated");
        }
        unset($obUser);
        //NOVA INSTANCIA DE DEPOIMENTOS
        $obUser = new EntityUser;
        $obUser->nome = $postVars['nome'] ?? '';
        $obUser->email = $postVars['email'] ?? '';
        $obUser->senha =  password_hash($postVars['senha'], PASSWORD_DEFAULT) ?? '';
        $obUser->cadastrar();

        //REDIRECIO O USUARIO
        $request->getRouter()->redirect(URL . "/admin/user?Status=created");
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
                return self::getAlertSuccess("Usúario cadastrado com sucesso");

                break;

            case 'updated':
                return self::getAlertSuccess("Usúario atualizado com sucesso");

                break;

            case 'delete':
                return self::getAlertSuccess("Usúario excluido com sucesso com sucesso");

                break;
            case 'duplicated':
                return self::getAlertError("E-mail já utilizado por outro usuário");

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
    public static function getEditUser($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect(URL . '/admin/user');
        }



        //CONTEÚDO 
        $content = [
            View::render("admin/modules/user/form", [
                'title' => 'Atualizar dados do usúario',
                'nome' => $obUser->nome,
                'email' => $obUser->email,
                'status' => self::getStatus($request),
            ]),

        ];

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Editar -> Depoimento", $content, 'users');
    }
    /**
     * Método responsavel por gravar a um depoimentos atualizado
     *
     * @param Request $request
     * @param string $id
     * @return string
     */
    public static function setEditUser($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect(URL . '/admin/user');
        }
        //POST VARS
        $postVars = $request->getPostVars();

        //ATUALIZA A INSTANCIA
        $obUser->nome = $postVars['nome'] ?? $obUser->nome;
        $obUser->email = $postVars['email'] ?? $obUser->email;
        $obUser->senha =  password_hash($postVars['senha'], PASSWORD_DEFAULT) ?? $obUser->senha;
        $obUser->atualizar();

        //REDIRECIO O USUARIO
        $request->getRouter()->redirect(URL . "/admin/user?Status=updated");
    }
    /**
     * Método responsavel por retornar o formulário de exclusão de um depoimento 
     *
     * @param Request $request
     * @param string $id
     * @return string
     */
    public static function getDeleteUser($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect(URL . '/admin/user');
        }

        //CONTEÚDO 
        $content = [
            View::render("admin/modules/user/delete", [
                'nome' => $obUser->nome,
                'email' => $obUser->email,
            ]),

        ];

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Excluir -> Depoimento", $content, 'user');
    }
    /**
     * Método responsavel por excluir um depoimento 
     *
     * @param Request $request
     * @param string $id
     * @return string
     */
    public static function setDeleteUser($request, $id)
    {
        //OBITEM DEPOIMETO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect(URL . '/admin/user');
        }

        //EXCLUI DEPOIMETO O DEPOIMETO DO BANCO 
        $obUser->excluir();

        //REDIRECIO O USUARIO
        $request->getRouter()->redirect(URL . "/admin/user?Status=delete");
    }
}
