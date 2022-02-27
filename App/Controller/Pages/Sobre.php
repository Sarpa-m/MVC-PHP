<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class Sobre extends Page
{
    /**
     * Metodo responsavel por retornar o conteúdo (View) da nossa home
     *
     * @return string
     */
    public static function getSobre()
    {

        $obOrganization = new Organization();
        
    

        $content =  View::render('pages/sobre', [
            "nome" => $obOrganization->nome,
            "description" => $obOrganization->description
        ]);
        return parent::getPage("Sobre > sarpa - MVC", $content);
    }
}
