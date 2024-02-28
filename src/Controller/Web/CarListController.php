<?php
namespace App\Controller\Web;

use App\Entity\Cars;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\Web\Controllers\GenericListController;

/**
    * @Route("/cars/list", name="cars_list")
*/
class CarListController extends GenericListController
{
    protected ?string $entity = Cars::class;
    protected ?int $perPage = 5;
    protected ?string $twig = 'car_app/car_list.html.twig';

    protected function onSetAttribute() : array 
    {
        return [
            'title' => 'Lista Samochodów'
        ];
    }

    protected function onQuerySet(): mixed
    {
        return $this->repository->getCarByName($this->request->get('name'));
    }
}
