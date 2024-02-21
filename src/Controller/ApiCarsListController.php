<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Generic\Api\ApiGenericListController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/api/cars/list", name="get_cars", methods={"GET"})
*/
class ApiCarsListController extends ApiGenericListController
{
    protected ?string $entity = Cars::class;
    protected int $perPage = 5;
}
