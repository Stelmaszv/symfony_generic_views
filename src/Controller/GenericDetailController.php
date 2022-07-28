<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cars;
use App\class\Generic;
use App\class\GenericInterFace;

class GenericDetailController extends AbstractController implements GenericInterFace
{
    use Generic;
    private int $id;

    protected function detailView(int $id,ManagerRegistry $doctrine): Response
    {
        $this->id=$id;
        return $this->baseView($doctrine);
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->find($this->id);
    }
}
