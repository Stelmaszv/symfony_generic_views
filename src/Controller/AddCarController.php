<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\GenericCreateController;
use App\Generic\GenericSetDataInterFace;
use App\Forms\Car;
use App\Entity\Cars;


class AddCarController extends GenericCreateController implements GenericSetDataInterFace
{
    public function setData(): void
    {
        $this->setForm(Car::class);
        $this->setTwig('car/form.twig');
        $this->setEntity(new Cars());
        $this->setSucess('Cars',["car"=>"geg"]);
    }

    protected function onAfterSaveSave():void
    {
        $this->addFlash(
            'notice',
            'Your car has been addad!'
        );
    }
}
