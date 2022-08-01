<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cars;
use App\Forms\Car;

class EditController extends AbstractController
{
    #[Route('/edit1/{id}', name: 'app_edit')]
    public function index(Request $request,ManagerRegistry $doctrine): Response
    {

        $id = $request->get('id');
        $category = $doctrine->getRepository(Cars::class)->find($id);
       
           if (!$category) {
               throw $this->notFoundException();
           }
           $form = $this->createForm(Car::class,$category);
           $form->handleRequest($request);
           if($form->isSubmitted() && $form->isValid()){
               $em = $doctrine->getManager();
               $categoryData = $form->getData();
               $em->persist($categoryData);
               $em->flush();
            /*
               $em = $this->getDoctrine()->getManager();
               $categoryData = $form->getData();
               $em->persist($categoryData);
               $em->flush();
              */ 
           }
       
        return $this->render('car/form.twig',array(
               'form' => $form->createView(),
        ));
    }
}
