<?php
namespace App\Controller\Web;
use App\Forms\Car;
use App\Entity\Cars;
use App\Generic\Web\GenericCreateController;

class AddCarController extends GenericCreateController
{
    protected string $twig = 'car/form.twig';
    protected string $form = Car::class;
    protected string $entity = Cars::class;

    protected function onAfterSaveSave() : void
    {
        $this->addFlash(
            'notice',
            'Your car has been addad!'
        );
        $this->createdUrl('CarDetail');
    }
}
