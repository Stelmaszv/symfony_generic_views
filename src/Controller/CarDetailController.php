<?php
namespace App\Controller;
use App\Entity\Cars;
use App\Generic\GenericDetailController;
use App\Generic\GenericSetDataInterFace;

class CarDetailController extends GenericDetailController
{
    protected $entity = Cars::class;
    protected string $twing = 'car/car_detail.twig';
}
