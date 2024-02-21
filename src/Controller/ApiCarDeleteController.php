<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Generic\Api\ApiGenericDeleteController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/api/car/{id}", name="car_delet", methods={"DELETE"})
*/
class ApiCarDeleteController extends ApiGenericDeleteController
{
    protected ?string $entity = Cars::class;
}
