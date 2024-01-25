<?php
namespace App\Generic;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

trait Generic{

    private array $attributes=[];
    protected Registry $doctrine;
    protected Request $request;
    protected $entity = NULL;
    protected string $twing = '';

    protected function baseView(Registry $doctrine,Request $request) : Response
    {
        $this->request=$request;
        $this->doctrine=$doctrine;
        $this->setData();
        $this->chcekData();
        return $this->render($this->twing, $this->addAttributes($doctrine));
    }
    
    protected function onSetAttribut() :array
    {
        return [];
    }

    protected function returnUrlArguments(string $argumant):string
    {
        return $this->request->attributes->get($argumant);
    }

    protected function getEntity(){
        return $this->entity;
    }

    protected function setEntity($Entity){
        $this->entity= $Entity;
    }

    protected function setTwig(string $twing){
        $this->twing= $twing;
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

    private function addAttributes(Registry $doctrine) :array
    {
        
        $this->attributes = [
            'object' => $this->getObjects()
        ];

        return array_merge($this->attributes, $this->onSetAttribut());
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