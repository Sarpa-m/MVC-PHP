<?php


namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class User
{
    /**
     * Id do Usuario
     *
     * @var int
     */
    public $id;

    /**
     * Nome do Usuario
     *
     * @var string
     */
    public $nome;

    /**
     * E-mail da Usuario 
     *
     * @var string
     */
    public $email;

    /**
     * senha do Usuario
     *
     * @var string
     */
    public $senha;
    /**
     * Método responsavel por retornar usuario apartir do email
     *
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email ="' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Metodoresponsavel por cadastrar a instancia atual no banca de dados
     *
     * @return boolean
     */
    public function cadastrar()
    {


        $this->id = (new Database('usuarios'))->insert([
            "nome" => $this->nome,
            "email" => $this->email,
            "senha" => $this->senha
        ]);

        return true;
    }

    /**
     * Método responsavel por retornar um Usuario
     *
     * @param  string $whwrw
     * @param  string $order
     * @param  string $limit
     * @param  string $field
     * @return \PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = "*")
    {
        return (new Database('usuarios'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método responsavel por retornar um depoimento com base no seu ID
     *
     * @param integer $id
     * @return User
     */
    public static function getUserById($id)
    {
        return self::getUsers("id = $id")->fetchObject(self::class);
    }
    /**
     * Método responsavel por atualizar os dados do banco com a intancia atual
     *
     * @return boolean
     */
    public function atualizar()
    {

        //ATUALIZA OS DADOS NO BANCO
        return (new Database('usuarios'))->update("id = " . $this->id, [
            "nome" => $this->nome,
            "email" => $this->email,
            "senha" => $this->senha
        ]);
    }

    /**
     * Método responsavel por excluir um depoimeto do banco
     *
     * @return boolean
     */
    public function excluir()
    {

        //APAGAR OS DADOS NA BANCO
        return (new Database('usuarios'))->delete("id = " . $this->id);
    }
}
