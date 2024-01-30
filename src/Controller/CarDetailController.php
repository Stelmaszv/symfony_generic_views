<?php
namespace App\Controller;
use App\Entity\Cars;
use App\Generic\GenericDetailController;

class CarDetailController extends GenericDetailController
{
    protected string $entity = Cars::class;
    protected string $twig = 'car/car_detail.twig';
}
