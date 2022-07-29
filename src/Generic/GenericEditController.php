<?php

namespace App\Generic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenericEditController extends AbstractController
{
    #[Route('/generic/edit', name: 'app_generic_edit')]
    public function index(): Response
    {
        return $this->render('generic_edit/index.html.twig', [
            'controller_name' => 'GenericEditController',
        ]);
    }
}
