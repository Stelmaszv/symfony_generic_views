<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Controller\DTO\CarDto;
use App\Generic\Api\ApiGenericCreateController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("api/car", name="car_add", methods={"POST"})
*/
class ApiAddCarController extends ApiGenericCreateController
{
    protected ?string $entity = Cars::class;
    protected ?string $dto = CarDto::class;
}
