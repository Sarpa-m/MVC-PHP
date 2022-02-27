<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class Home extends Page
{
    /**
     * Metodo responsavel por retornar o conteúdo (View) da nossa home
     *
     * @return string
     */
    public static function getHome()
    {

        $obOrganization = new Organization();
        
    

        $content =  View::render('pages/home', [
            "nome" => $obOrganization->nome,
          
        ]);
        return parent::getPage("Home > sarpa - MVC", $content);
    }
}
