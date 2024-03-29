<?php
namespace App\Controller\Web;

use App\Forms\Car;
use App\Entity\Cars;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Generic\Web\Controllers\GenericUpdateController;

/**
    * @Route("/edit_car/{id}", name="edit_car")
*/
class EditCarController extends GenericUpdateController
{
    protected ?string $entity = Cars::class;
    protected ?string $twig = 'car_app/car_form.twig';
    protected ?string $form = Car::class;

    protected function onSetAttribute() : array 
    {
        return [
            'title' => 'Edit '.$this->item->getName()
        ];
    }

    protected function onAfterValid() : void {

        $this->addFlash(
            'notice',
            'Object '.$this->item->getName().' was added'
        );

        $response = new RedirectResponse($this->generateUrl('cars_list'));
        $response->send();
        exit; 
    }
}
