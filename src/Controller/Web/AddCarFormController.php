<?php

namespace App\Controller\Web;

use App\Forms\Car;
use App\Generic\Web\GenericFormController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
    * @Route("/form", name="form_external")
*/
class AddCarFormController extends GenericFormController
{
    protected string $form = Car::class;
    protected string $twig = 'car_app/car_form.twig';

    protected function onAfterValid() : void {

        $this->addFlash(
            'notice',
            'Object was sent destroy'
        );

        $response = new RedirectResponse($this->generateUrl('cars_list'));
        $response->send();
        exit; 
    }
}
