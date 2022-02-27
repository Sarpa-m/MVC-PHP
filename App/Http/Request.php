<?php

namespace App\Http;

class Request
{

    /**
     * Método Http da requisição
     *
     * @var mixed
     */
    private $httpMethod;

    /**
     * URI da pagina (rota)
     *
     * @var mixed
     */
    private $uri;

    /**
     * Parâmetros da URL ($_GET) 
     *
     * @var mixed
     */
    private $queyParams = [];

    /**
     * Variáves do POST da pagina ($_POST)
     *
     * @var mixed
     */
    private $postVars = [];

    /**
     * Cabesolha da requisição
     *
     * @var array
     */
    private $headers = [];

    /**
     * Cookie da pagina 
     *
     * @var array
     */
    private  $cookie = [];

    public function __construct()
    {
        $this->queyParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->cookie = $_COOKIE ?? [];
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * Método responsavel por retornar o método HTTP da requisição
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }
    /**
     * Método responsavel por retornar o URI da requisição
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
    /**
     * Método responsavel por retornar o URI da requisição
     *
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }
    /**
     * Método responsavel por retornar os queyParams da requisição
     *
     * @return string
     */
    public function getQueyParams()
    {
        return $this->queyParams;
    }
    /**
     * Método responsavel por retornar os post Vars da requisição
     *
     * @return string
     */
    public function getPostVars()
    {
        return $this->postVars;
    }
    /**
     * Método responsavel por retornar os cookies da requisição
     *
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie;
    }
}
