<?php
namespace App\Generic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Generic\Generic;
use App\Generic\GenericInterFace;

abstract class GenericListController extends AbstractController implements GenericInterFace
{ 
    use Generic;

    protected int $per_page = 2;

    protected function listView(ManagerRegistry $doctrine): Response
    {
        return $this->baseView($doctrine);
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->findAll();
    }

    private function preaperQuerySet($entityManager)
    {
       $data= $entityManager->getRepository($this->entity);
       $query = $this->onQuerySet($data);
       return $this->paginator->paginate(
            $query,
            $this->request->query->getInt('page', 1),
            5
        );
    }


}
