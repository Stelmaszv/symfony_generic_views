<?php
namespace App\Controller;
use App\Generic\GenericListController;
use App\Generic\GenericSetDataInterFace;
use App\Entity\Cars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CarListController extends GenericListController implements GenericSetDataInterFace
{
    private string $car;
    protected int $per_page = 10;
    protected bool $paginate = true;
    
    public function setData(): void
    {
        $this->setEntity(Cars::class);
        $this->setTwig('car/car_list.html.twig');
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->getCarByName($this->returnUrlArguments('car'));
    }

    protected function onSetAttribut() :array
    {
        return  [
            'title' => 'Cars'
        ];
    }

}
