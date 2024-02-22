<?php
namespace App\Controller\Web;
use App\Entity\Cars;
use App\Generic\Web\GenericListController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/cars/list", name="cars_list")
*/
class CarListController extends GenericListController
{
    protected ?string $entity = Cars::class;
    protected ?int $perPage = 5;
    protected ?string $twig = 'car_app/car_list.html.twig';

    protected function onSetAttribut(){
        return [
            'title' => 'Lista Carsów'
        ];
      }
}
