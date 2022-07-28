<?php
namespace App\Generic;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Response;

trait Generic{

    private $entity=NULL;
    private string $twing='';

    protected function baseView(Registry $doctrine) : Response
    {
        $this->setData();
        $this->chcekData();
        return $this->render($this->twing, [
            'object' => $this->getObjects($doctrine)
        ]);
    }

    private function chcekData() :void
    {
        if(!$this->entity) {
            throw new \Exception("Entity is not define in controller ".get_class($this)."!");
        }

        if(!$this->twing) {
            throw new \Exception("Twing is not define in controller ".get_class($this)."!");
        }
    }

    protected function setEntity(string $Entity){
        $this->entity= $Entity;
    }

    protected function setTwig(string $twing){
        $this->twing= $twing;
    }

    private function getObjects(Registry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        return $this->preaperQuerySet($entityManager);
    }

    private function preaperQuerySet($entityManager)
    {
        return $this->onQuerySet($entityManager->getRepository($this->entity));
    }
    
}