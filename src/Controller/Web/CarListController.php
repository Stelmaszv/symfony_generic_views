<?php
namespace App\Controller\Web;
use App\Entity\Cars;
use App\Generic\Web\GenericListController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/cars/list", name="car_list")
*/
class CarListController extends GenericListController
{
    protected ?string $entity = Cars::class;
    protected ?int $perPage = 5;
}
