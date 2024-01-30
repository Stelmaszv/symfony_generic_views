<?php
namespace App\Controller;
use App\Generic\GenericDeleteController;
use App\Entity\Cars;

class DeleteCarController extends GenericDeleteController
{
    protected string $entity = Cars::class;

    protected function onAfterDelete():void{
        $this->setSucess('Cars');
        $this->addFlash(
            'notice',
            'Object was destroy'
        );
    }
}
