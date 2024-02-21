<?php

namespace App\Controller\API;

use App\Entity\Cars;
use App\Generic\Api\GenericDetailController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("api/car/{id}", name="api_car", methods={"GET"})
*/
class ApiGetCar extends GenericDetailController
{
    protected ?string $entity = Cars::class;
}