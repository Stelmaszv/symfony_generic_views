<?php
namespace App\Controller;
use App\Entity\Cars;
use App\Generic\GenericDetailController;
use App\Generic\GenericSetDataInterFace;

class CarDetailController extends GenericDetailController implements GenericSetDataInterFace
{
    public function setData(): void
    {
        $this->setEntity(Cars::class);
        $this->setTwig('car/car_detail.twig');
    }
}
