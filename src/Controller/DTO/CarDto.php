<?php

namespace App\Controller\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CarDto
{
    /**
     * @Assert\NotBlank
     */
    public $name;
}
