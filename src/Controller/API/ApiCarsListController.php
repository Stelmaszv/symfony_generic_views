<?php

namespace App\Controller\API;

use App\Entity\Cars;
use App\Generic\Api\GenericListController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/api/cars/list", name="get_cars", methods={"GET"})
*/
class ApiCarsListController extends GenericListController
{
    protected ?string $entity = Cars::class;
    protected int $perPage = 5;
}
