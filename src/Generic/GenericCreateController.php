<?php
namespace App\Generic;
use App\Generic\GenericFormController;

class GenericCreateController extends GenericFormController implements GenericSetDataInterFace
{
    private int $inserdId;

    protected function getForm(){
        $this->setEntity(new $this->entity());
        return $this->createForm($this->form,$this->getEntity());
    }

    protected function onAfterValid($form)
    {
        $entity= $this->getEntity();
        $this->onBeforeSave();
        $em = $this->doctrine->getManager();
        $em->persist($entity);
        $em->flush();
        $this->inserdId = $entity->getId();
        $this->onAfterSaveSave();
    }

    protected function createdUrl(string $url):void{
       $this->setSucess(
            $url,[
                'id' => $this->inserdId
            ]
        );
    }

    protected function onAfterSaveSave():void{}

    protected function onBeforeSave():void{}

    public function setData(): void{}
}
