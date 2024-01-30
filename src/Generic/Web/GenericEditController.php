<?php

namespace App\Generic\Web;

use Symfony\Component\Form\Form;
use App\Generic\Web\GenericFormController;

class GenericEditController extends GenericFormController
{
    protected function getQuery(int $id) : mixed
    {
        return $this->doctrine->getManager()->getRepository($this->getEntity())->find($id); 
    }

    private function chcekData() : void
    {
        if(!$this->entity) {
            throw new \Exception("Entity is not define in controller ".get_class($this)."!");
        }

        if(!$this->form) {
            throw new \Exception("Form is not define in controller ".get_class($this)."!");
        }

        if(!$this->twig) {
            throw new \Exception("Twing is not define in controller ".get_class($this)."!");
        }
    }

    protected function getForm() : Form
    {
        return $this->createForm($this->form, $this->getQuery($this->returnUrlArguments('id')));
    }

    protected function onAfterValid(Form $form) : void
    {
        $this->chcekData();
        $this->onBeforeSave();
        $em = $this->doctrine->getManager();
        $categoryData = $form->getData();
        $em->persist($categoryData);
        $em->flush();
        $this->onAfterSaveSave();
    }

    protected function onAfterSaveSave() : void {}

    protected function onBeforeSave() : void {}
}


