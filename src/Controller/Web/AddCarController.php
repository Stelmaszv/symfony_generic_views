<?php
namespace App\Controller\Web;
use App\Forms\Car;
use App\Entity\Cars;
use App\Generic\Web\GenericCreateController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
    * @Route("/add_car", name="add_car")
*/
class AddCarController extends GenericCreateController
{
    protected ?string $twig = 'car_app/car_form.twig';
    protected ?string $form = Car::class;
    protected ?string $entity = Cars::class;

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
