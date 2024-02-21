<?php

namespace App\Controller\API;

use App\Entity\Cars;
use App\Generic\Api\GenericDeleteController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/api/car/{id}", name="car_delete", methods={"DELETE"})
*/
class ApiCarDeleteController extends GenericDeleteController
{
    protected ?string $entity = Cars::class;
}
