<?php

namespace App\Controller\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CompanyDto
{
    /**
     * @Assert\NotNull
     */
    public $name;
}
