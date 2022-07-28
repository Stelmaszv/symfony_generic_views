<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\class\Generic;
use App\class\GenericInterFace;

abstract class GenericListController extends AbstractController implements GenericInterFace
{ 
    use Generic;
    protected function listView(ManagerRegistry $doctrine): Response
    {
        return $this->baseView($doctrine);
    }

    protected function on_query_set($entityManager) : array
    {
        return $entityManager->findAll();
    }

}
