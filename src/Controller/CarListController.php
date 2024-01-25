<?php
namespace App\Controller;
use App\Generic\GenericListController;
use App\Generic\GenericSetDataInterFace;
use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CarListController extends GenericListController
{
    protected int $per_page = 10;
    protected bool $paginate = true;
    protected $entity = Cars::class;
    protected string $twing = 'car/car_list.html.twig';
    
    protected function onSetAttribut() :array
    {
        return  [
            'title' => 'Cars'
        ];
    }

}
