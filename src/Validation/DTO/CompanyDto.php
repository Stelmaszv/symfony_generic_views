<?php

namespace App\Controller\DTO;

use App\Generic\Api\Interfaces\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class CarDto implements DTO
{
    /**
     * @Assert\NotNull
     */
    public $name;
}
