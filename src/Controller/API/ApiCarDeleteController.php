<?php

namespace App\Controller\API;

use App\Entity\Cars;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\Api\Controllers\GenericDeleteController;

/**
    * @Route("/api/car/{id}", name="car_delete", methods={"DELETE"})
*/
class ApiCarDeleteController extends GenericDeleteController
{
    protected ?string $entity = Cars::class;
}
