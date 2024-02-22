<?php
namespace App\Generic\Web;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class GenericDetailController extends AbstractController implements GenericInterFace, GenericSetDataInterFace
{
    use Generic;
    private int $id;

    public function detailView(ManagerRegistry $doctrine,Request $request,int $id): Response
    {
        $this->id = $id;
        return $this->baseView($doctrine,$request);
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->find($this->id);
    }

    public function setData(): void {}
}

