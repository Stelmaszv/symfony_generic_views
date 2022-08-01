<?php
namespace App\Generic;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Response;

trait Generic{

    private $entity=NULL;
    private string $twing='';
    private array $attributes=[];

    protected function baseView(Registry $doctrine) : Response
    {
        $this->setData();
        $this->chcekData();
        return $this->render($this->twing, $this->addAttributes($doctrine));
    }
    
    protected function onSetAttribut() :array
    {
        return [];
    }

    protected function return_url_arguments():array
    {
        return explode("/", $_SERVER['REQUEST_URI']);
    }

    private function addAttributes(Registry $doctrine) :array
    {
        
        $this->attributes = [
            'object' => $this->getObjects($doctrine)
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