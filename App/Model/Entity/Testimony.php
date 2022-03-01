<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Testimony
{
    /**
     * ID do depoimento
     *
     * @var int
     */
    public $id;

    /**
     * Nome da usuário que fez o depoimento
     *
     * @var string
     */
    public $nome;

    /**
     * Mesagem do depoimento
     *
     * @var string
     */
    public $mensagem;

    /**
     * Data de puclicação do depoimento
     *
     * @var string
     */
    public $data;

    /**
     * Metodoresponsavel por cadastrar a instancia atual no banca de dados
     *
     * @return boolean
     */
    public function cadastrar()
    {
        //define a data 
        $this->data = date("y-m-d h:i:s");

        $this->id = (new Database('depoimentos'))->insert([
            "nome" => $this->nome,
            "mensagem" => $this->mensagem,
            "data" => $this->data
        ]);

    return true;
    }
    
    /**
     * Método responsavel por retornar Depoimetos
     *
     * @param  string $whwrw
     * @param  string $order
     * @param  string $limit
     * @param  string $field
     * @return \PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = "*")
    {
       return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}
