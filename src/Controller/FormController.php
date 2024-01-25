<?php

namespace App\Controller;

use App\Generic\GenericFormController;
use App\Generic\GenericSetDataInterFace;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Forms\Car;

class FormController extends GenericFormController
{
    protected string $twing = 'car/form.twig';
    protected string $form = Car::class;
}
