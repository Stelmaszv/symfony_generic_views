<?php

namespace App\Controller\Web;

use App\Entity\Cars;
use App\Generic\Web\GenericDeleteController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/car/delete/{id}", name="delete_car")
*/
class CarDeleteController  extends GenericDeleteController
{
    protected ?string $entity = Cars::class; 

    protected function setRedirect() : void {
        $this->redirect->setName('car_show');
        $this->redirect->setAttributes([
            "id" => 32
        ]);
    }

    protected function setFlashMessage() : void {
        $this->flash->setType('notice');
        $this->flash->setMessage('Object '.$this->item->getName().' destroy');
    }
}