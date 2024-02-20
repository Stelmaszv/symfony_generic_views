<?php

namespace App\Controller\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CarDto
{
    /**
     * @Assert\NotNull
     */
    public ?string $name = null;

    public ?int $company = null;
}
