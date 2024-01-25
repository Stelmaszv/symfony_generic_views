<?php

namespace App\Controller;
use App\Generic\GenericEditController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\GenericSetDataInterFace;
use App\Forms\Car;
use App\Entity\Cars;

class CarEditController extends GenericEditController implements GenericSetDataInterFace
{
    protected $entity = Cars::class;
    protected string $twing = 'car/form.twig';
    protected string $form= Car::class;

    public function setData(): void
    {
        $this->setSucess('CarDetail',[
            "id"=>$this->returnUrlArguments('id')
        ]);
    }

    protected function onAfterSaveSave():void
    {
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
    }
}
