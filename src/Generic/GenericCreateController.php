<?php
namespace App\Generic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\GenericFormController;
use App\Entity\Cars;

class GenericCreateController extends GenericFormController
{
    protected function getForm(){
        $entity= $this->getEntity();
        return $this->createForm($this->form,$entity);
    }

    protected function onAfterValid($form)
    {
        $entity= $this->getEntity();
        $this->onBeforeSave();
        $em = $this->doctrine->getManager();
        $em->persist($entity);
        $em->flush();
        $this->inserdId=$entity->getId();
        $this->onAfterSaveSave();
    }

    protected function createdUrl(string $url):void{
       $this->setSucess($url,['id'=>$this->inserdId]);
    }

    protected function onAfterSaveSave():void{}

    protected function onBeforeSave():void{}
}
