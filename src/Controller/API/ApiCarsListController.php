<?php

namespace App\Controller\API;

use App\Entity\Cars;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\Api\Controllers\GenericListController;

/**
    * @Route("/api/cars/list", name="get_cars", methods={"GET"})
*/
class ApiCarsListController extends GenericListController
{
    protected ?string $entity = Cars::class;
    protected int $perPage = 5;
}
