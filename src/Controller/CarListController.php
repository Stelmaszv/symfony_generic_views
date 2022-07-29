<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\GenericListController;
use App\Generic\GenericSetDataInterFace;
use App\Entity\Cars;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class CarListController extends GenericListController implements GenericSetDataInterFace
{
    private string $car;

    #[Route('/car/list/{car}', name: 'app_cars_list')]
    public function index(ManagerRegistry $doctrine,string $car,Request $request, PaginatorInterface $paginator): Response
    {
        $this->car=$car;
        $this->request=$request;
        $this->paginator=$paginator;
        return $this->listView($doctrine);
    }

    public function setData(): void
    {
        $this->setEntity(Cars::class);
        $this->setTwig('generic_list/index.html.twig');
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->getCarByName($this->car);
    }

    protected function onSetAttribut() :array
    {
        return  [
            'viewNmae' => 'viewNmae'
        ];
    }

}
