<?php
namespace App\Generic\Web;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

trait Generic{

    private array $attributes=[];
    protected string $entity;
    protected string $twig;

    protected function baseView(Registry $doctrine,Request $request) : Response
    {
        $this->request=$request;
        $this->doctrine=$doctrine;
        $this->setData();
        $this->chcekData();
        return $this->render($this->twig, $this->addAttributes($doctrine));
    }
    
    protected function onSetAttribut() : array
    {
        return [];
    }

    protected function returnUrlArguments(string $argumant) : string
    {
        return $this->request->attributes->get($argumant);
    }

    protected function setData() : void {}

    protected function getEntity() : string
    {
        return $this->entity;
    }

    protected function setEntity(string $entity) : void 
    {
        $this->entity = $entity;
    }

    protected function setTwig(string $twig) : void
    {
        $this->twig = $twig;
    }
    
    private function chcekData() : void
    {
        if(!$this->entity) {
            throw new \Exception("Entity is not define in controller ".get_class($this)."!");
        }

        if(!$this->twig) {
            throw new \Exception("Twing is not define in controller ".get_class($this)."!");
        }
    }

    private function addAttributes(Registry $doctrine) : array
    {
        
        $this->attributes = [
            'object' => $this->getObjects()
        ];

        return array_merge($this->attributes, $this->onSetAttribut());
    }

    private function getObjects() : mixed
    {
        return $this->preaperQuerySet($this->doctrine->getManager());
    }

    private function preaperQuerySet($entityManager) : mixed
    {
        return $this->onQuerySet($entityManager->getRepository($this->entity));
    }
}