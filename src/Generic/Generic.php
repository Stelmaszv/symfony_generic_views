<?php
namespace App\Generic;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Response;

trait Generic{

    private $entity=NULL;
    private string $twing='';
    private array $attributes=[];
    protected Registry $doctrine;

    protected function baseView(Registry $doctrine) : Response
    {
        $this->doctrine=$doctrine;
        $this->setData();
        $this->chcekData();
        return $this->render($this->twing, $this->addAttributes($doctrine));
    }
    
    protected function onSetAttribut() :array
    {
        return [];
    }

    protected function returnUrlArguments():array
    {
        return explode("/", $_SERVER['REQUEST_URI']);
    }

    private function addAttributes(Registry $doctrine) :array
    {
        
        $this->attributes = [
            'object' => $this->getObjects()
        ];

        return array_merge($this->attributes, $this->onSetAttribut());
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

    protected function setEntity($Entity){
        $this->entity= $Entity;
    }

    protected function setTwig(string $twing){
        $this->twing= $twing;
    }

    private function getObjects()
    {
        return $this->preaperQuerySet($this->doctrine->getManager());
    }

    private function preaperQuerySet($entityManager)
    {
        return $this->onQuerySet($entityManager->getRepository($this->entity));
    }
}