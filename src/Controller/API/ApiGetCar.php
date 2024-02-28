<?php

namespace App\Controller\API;

use App\Entity\Cars;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\Api\Controllers\GenericDetailController;

/**
    * @Route("api/car/{id}", name="api_car", methods={"GET"})
*/
class ApiGetCar extends GenericDetailController
{
    protected ?string $entity = Cars::class;
}