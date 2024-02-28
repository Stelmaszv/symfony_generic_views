<?php
namespace App\Controller\API;

use App\Entity\Cars;
use App\Validation\DTO\CarDto;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\Api\Controllers\GenericCreateController;

/**
    * @Route("api/car", name="car_add", methods={"POST"})
*/
class ApiAddCarController extends GenericCreateController
{
    protected ?string $entity = Cars::class;
    protected ?string $dto = CarDto::class;
}
