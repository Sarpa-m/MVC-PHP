<?php

namespace App\Model\Entity;

class Organization
{

    /**
     * ID da otganização
     *
     * @var int
     */
    public $id = 1;


    /**
     * nome da organização 
     *
     * @var string
     */
    public $nome = "sarpa dev";

    /**
     * site da organização
     *
     * @var string
     */
    public $site = "www.sarpa.dev";

    /**
     * Descrição da organizaça
     *
     * @var string
     */
    public $description = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni sequi illo quisquam temporibus" .
        "dolor doloremque, tempore ex, velit sint accusantium repellendus asperiores assumenda itaque" .
        " veniam eius. Excepturi accusantium distinctio voluptatum.";
}
