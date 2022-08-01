<?php
namespace App\Controller;
use App\Generic\GenericListController;
use App\Generic\GenericSetDataInterFace;
use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CarListController extends GenericListController implements GenericSetDataInterFace
{
    private string $car;
    protected int $per_page = 4;

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->getCarByName($this->return_url_arguments()[3]);
    }

    public function setData(): void
    {
        $this->setEntity(Cars::class);
        $this->setTwig('car/car_list.html.twig');
    }

    protected function onSetAttribut() :array
    {
        return  [
            'title' => 'Cars'
        ];
    }

}