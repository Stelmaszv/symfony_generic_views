<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Cars;


class ListNoGenericController extends AbstractController
{
    #[Route('/list/no/generic', name: 'app_list_no_generic')]
    public function index(Request $request,ManagerRegistry $doctrine,PaginatorInterface $paginator): Response
    {
        $entity=Cars::class;
        $query= $doctrine->getRepository($entity)->findAll();
        $objects= $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('list_no_generic/index.html.twig', [
            'object' => $objects
        ]);
    }
}
