<?php

namespace App\Controller;
use App\Forms\Car;
use App\Entity\Cars;
use App\Generic\Web\GenericEditController;

class CarEditController extends GenericEditController
{
    protected string $entity = Cars::class;
    protected string $twig = 'car/form.twig';
    protected string $form = Car::class;

    protected function onAfterSaveSave():void
    {
        $this->setSucess('CarDetail',[
            "id"=>$this->returnUrlArguments('id')
        ]);
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
    }
}
