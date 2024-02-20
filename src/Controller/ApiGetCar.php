<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Generic\Api\ApiGenericDetailController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("api/car/{id}", name="api_car", methods={"GET"})
*/
class ApiGetCar extends ApiGenericDetailController
{
    protected ?string $entity = Cars::class;
}