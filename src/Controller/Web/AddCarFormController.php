<?php
namespace App\Controller\Web;

use App\Forms\Car;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\Web\Controllers\GenericFormController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
    * @Route("/form", name="form")
*/
class AddCarFormController extends GenericFormController
{
    protected ?string $form = Car::class;
    protected ?string $twig = 'car_app/car_form.twig';

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
