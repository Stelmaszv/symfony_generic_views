<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\GenericListController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cars;


class CarListController extends GenericListController
{
    private string $car;
    #[Route('/car/list/{car}', name: 'app_cars_list')]
    public function index(ManagerRegistry $doctrine,string $car): Response
    {
        $this->car=$car;
        return $this->listView($doctrine);
    }

    public function setData(): void
    {
        $this->setEntity(Cars::class);
        $this->setTwig('generic_list/index.html.twig');
    }

    protected function on_query_set($entityManager) : array
    {
        return $entityManager->getCarByName($this->car);
    }


}
