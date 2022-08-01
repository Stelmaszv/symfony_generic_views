<?php

namespace App\Generic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Forms\Car;

class GenericFormController extends AbstractController
{
    public function form(Request $request): Response
    {
        $form = $this->createForm(Car::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $this->onSubmittedTrue();
            if ($form->isValid()){
                $this->onValid();
            }else{
                $this->onInValid();
            }
        }else{
            $this->onSubmittedFalse();
        }

        return $this->render('car/form.twig', [
            'controller_name' => 'GenericFormController',
            'form'=> $form->createView()
        ]);
    }

    protected function onSubmittedTrue():void{}

    protected function onSubmittedFalse():void{}

    protected function onValid():void{}

    protected function onInValid():void{}
}
