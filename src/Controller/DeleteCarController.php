<?php
namespace App\Controller;
use App\Generic\GenericDeleteController;
use App\Entity\Cars;

class DeleteCarController extends GenericDeleteController
{
    protected $entity = Cars::class;

    public function setData(): void
    {
        $this->setSucess('Cars');
    }

    protected function onAfterDelete():void{
        $this->addFlash(
            'notice',
            'Object was destroy'
        );
    }
}
