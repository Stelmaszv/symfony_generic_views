<?php
namespace App\Generic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Generic\Generic;
use App\Generic\GenericInterFace;

class GenericDetailController extends AbstractController implements GenericInterFace
{
    use Generic;
    private int $id;

    public function detailView(ManagerRegistry $doctrine,int $id): Response
    {
        $this->id=$id;
        return $this->baseView($doctrine);
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->find($this->id);
    }
}
