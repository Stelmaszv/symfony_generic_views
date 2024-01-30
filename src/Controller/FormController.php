<?php

namespace App\Controller;

use App\Forms\Car;
use App\Generic\Web\GenericFormController;

class FormController extends GenericFormController
{
    protected string $twing = 'car/form.twig';
    protected string $form = Car::class;
}
