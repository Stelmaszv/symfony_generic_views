<?php

namespace App\Validation\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CarDto
{
    /**
     * @Assert\NotNull
     */
    public ?string $name = null;

    public ?int $company = null;
}
