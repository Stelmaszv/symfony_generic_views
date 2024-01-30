<?php

namespace App\Generic;

use App\Generic\GenericFormController;

class GenericEditController extends GenericFormController
{
    protected function getQuery(int $id)
    {
        return $this->doctrine->getManager()->getRepository($this->getEntity())->find($id); 
    }

    private function chcekData() :void
    {
        if(!$this->entity) {
            throw new \Exception("form is not define in controller ".get_class($this)."!");
        }

        if(!$this->form) {
            throw new \Exception("form is not define in controller ".get_class($this)."!");
        }

        if(!$this->twing) {
            throw new \Exception("Twing is not define in controller ".get_class($this)."!");
        }
    }

    protected function getForm(){
        return $this->createForm($this->form, $this->getQuery($this->returnUrlArguments('id')));
    }

    protected function onAfterValid($form)
    {
        $this->chcekData();
        $this->onBeforeSave();
        $em = $this->doctrine->getManager();
        $categoryData = $form->getData();
        $em->persist($categoryData);
        $em->flush();
        $this->onAfterSaveSave();
    }

    protected function onAfterSaveSave():void{}

    protected function onBeforeSave():void{}
}


