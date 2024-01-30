<?php
namespace App\Controller;
use App\Entity\Cars;
use App\Generic\Web\GenericDeleteController;

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
