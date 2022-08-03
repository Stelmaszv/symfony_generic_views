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
    public function setData(): void
    {
        $this->setForm(Car::class);
        $this->setTwig('car/form.twig');
        $this->setEntity(Cars::class);
        $this->setSucess('CarDetail',[
            "id"=>$this->returnUrlArguments()[3]
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
