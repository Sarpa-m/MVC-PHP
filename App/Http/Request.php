<?php

namespace App\Http;

use App\Http\Router;

class Request
{

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
    /**
     * intacia de router
     *
     * @var Router
     */
    private $router;

    public function __construct($router)
    {
        $this->queyParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->cookie = $_COOKIE ?? [];
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->router = $router;
    }
    /**
     * Método responsavel por definir a URI
     *
     * @return void
     */
    private function setUri()
    {
        $uri = explode("?", ($_SERVER['REQUEST_URI'] ?? ''))[0];
        $uri = preg_replace('#/$#', '', $uri);
        $uri .= "/";
        $this->uri = $uri;
    }
    /**
     * Método resposaver por retornar a intacia de Router
     *
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
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
     * @return array
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
