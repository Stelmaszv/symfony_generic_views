<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Generic\Api\ApiGenericDetailController;

class ApiGetCar extends ApiGenericDetailController
{
    protected ?string $entity = Cars::class;
}
