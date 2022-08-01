<?php
namespace App\Generic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\GenericFormController;
use App\Entity\Cars;

class GenericCreateController extends GenericFormController
{
    var $entity;

    protected function getForm($entity,$request){
        return $this->createForm($this->form,$entity);
    }

    protected function onAfterValid($form,$entity)
    {
        $this->onBeforeSave();
        $em = $this->doctrine->getManager();
        $em->persist($entity);
        $em->flush();
        $this->onAfterSaveSave();
    }

    
    protected function onAfterSaveSave():void{}

    protected function onBeforeSave():void{}
}
