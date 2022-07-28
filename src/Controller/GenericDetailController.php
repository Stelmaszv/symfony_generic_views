<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cars;
use App\class\Generic;
use App\class;
use App\class\GenericInterFace;

abstract class GenericDetailController extends AbstractController implements GenericInterFace
{
    use Generic;
    private int $id;

    #[Route('/car/detail/{id}', name: 'app_car_detail')]
    public function detailView(int $id,ManagerRegistry $doctrine): Response
    {
        $this->id=$id;
        return $this->baseView($doctrine);
    }

    protected function on_query_set(ServiceEntityRepository $entityManager)
    {
        return $entityManager->find($this->id);
    }
}
