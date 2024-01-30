<?php
namespace App\Controller;
use App\Generic\GenericListController;
use App\Entity\Cars;

class CarListController extends GenericListController
{
    protected int $per_page = 10;
    protected bool $paginate = true;
    protected string $entity = Cars::class;
    protected string $twig = 'car/car_list.html.twig';
    
    protected function onSetAttribut() : array
    {
        return  [
            'title' => 'Cars'
        ];
    }

}
