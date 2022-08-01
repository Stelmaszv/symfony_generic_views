<?php

namespace App\Generic;

use App\Generic\GenericFormController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cars;

class GenericEditController extends GenericFormController
{
    protected function getEntity($entity,int $id)
    {
        return $this->doctrine->getManager()->getRepository($entity)->find($id); 
    }

    private function chcekData() :void
    {
        if(!$$this->entity) {
            throw new \Exception("form is not define in controller ".get_class($this)."!");
        }

        if(!$this->form) {
            throw new \Exception("form is not define in controller ".get_class($this)."!");
        }

        if(!$this->twing) {
            throw new \Exception("Twing is not define in controller ".get_class($this)."!");
        }
    }

    protected function getForm($entity,$request){
        return $this->createForm($this->form, $this->getEntity($entity,$request->get('id')));
    }

    protected function onAfterValid($form)
    {
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


