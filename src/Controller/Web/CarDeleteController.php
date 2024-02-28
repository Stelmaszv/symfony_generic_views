<?php
namespace App\Controller\Web;

use App\Entity\Cars;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Generic\Web\Controllers\GenericDeleteController;

/**
    * @Route("/car/delete/{id}", name="delete_car")
*/
class CarDeleteController extends GenericDeleteController
{
    protected ?string $entity = Cars::class; 
    protected ?string $redirectTo = 'cars_list';

    protected function afterDelete(): void {
        $this->addFlash(
            'notice',
            'Object '.$this->item->getName().' destroy'
        );

        $response = new RedirectResponse($this->generateUrl('cars_list'));
        $response->send();
        exit; 
    }
}
