<?php

namespace App\Controller\Web;

use App\Entity\Cars;
use App\Generic\Web\GenericDetailController;
use Symfony\Component\Routing\Annotation\Route;

/**
    * @Route("/car/get/{id}", name="car_show")
*/
class CarController extends GenericDetailController
{
    protected ?string $entity = Cars::class;
    protected ?string $twig = 'car_app/car_detail.twig';

    protected function onSetAttribute() : array 
    {
        return [
            'title' => $this->item->getName()
        ];
    }
}
