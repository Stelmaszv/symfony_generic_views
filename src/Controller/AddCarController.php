<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\GenericCreateController;
use App\Generic\GenericSetDataInterFace;
use App\Forms\Car;
use App\Entity\Cars;


class AddCarController extends GenericCreateController
{
    protected string $twing = 'car/form.twig';
    protected string $form= Car::class;
    protected $entity = Cars::class;

    protected function onAfterSaveSave():void
    {
        $this->addFlash(
            'notice',
            'Your car has been addad!'
        );
        $this->createdUrl('CarDetail');
    }
}
