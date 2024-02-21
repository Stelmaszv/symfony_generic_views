<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Controller\DTO\CarDto;
use App\Generic\Api\ApiGenericUpdateController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/car/{id}", name="api_car_update", methods={"PUT"})
*/
class APiCarUpdateController extends ApiGenericUpdateController
{
    protected ?string $entity = Cars::class;
    protected ?string $dto = CarDto::class;
}
