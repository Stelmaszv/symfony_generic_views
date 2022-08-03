<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\GenericDeleteController;
use App\Generic\GenericSetDataInterFace;
use App\Generic\Generic;
use App\Entity\Cars;

class DeleteCarController extends GenericDeleteController implements GenericSetDataInterFace
{
    public function setData(): void
    {
        $this->setEntity(Cars::class);
        $this->setSucess('Cars');
    }

    protected function onAfterDelete():void{
        $this->addFlash(
            'notice',
            'Object was destroy'
        );
    }
}
