<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Generic\Api\ApiGenericListController;

class ApiCarsListController extends ApiGenericListController
{
    protected ?string $entity = Cars::class;
    protected int $perPage = 3;
}
