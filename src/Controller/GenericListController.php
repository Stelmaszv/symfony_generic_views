<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cars;

class GenericListController extends AbstractController
{
    #[Route('/generic/list', name: 'app_generic_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $objects = $entityManager->getRepository(Cars::class)->findAll();
        return $this->render('generic_list/index.html.twig', [
            'objects'=> $objects
        ]);
    }
}
