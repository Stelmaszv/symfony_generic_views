<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Generic\GenericListController;
use App\Generic\GenericSetDataInterFace;
use App\Entity\Cars;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class CarListController extends GenericListController implements GenericSetDataInterFace
{
    private string $car;
    protected int $per_page = 4;

    #[Route('/car/list/{car}', name: 'app_cars_list')]
    public function index(ManagerRegistry $doctrine,string $car,Request $request, PaginatorInterface $paginator): Response
    {
        $this->car=$car;
        return $this->listView($doctrine,$request,$paginator);
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->getCarByName($this->car);
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
