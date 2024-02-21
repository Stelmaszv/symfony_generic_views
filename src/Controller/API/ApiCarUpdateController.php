<?php

namespace App\Controller\API;

use App\Entity\Cars;


use App\Validation\DTO\CarDto;
use App\Generic\Api\GenericUpdateController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/car/{id}", name="api_car_update", methods={"PUT"})
*/
class ApiCarUpdateController extends GenericUpdateController
{
    protected ?string $entity = Cars::class;
    protected ?string $dto = CarDto::class;
}
