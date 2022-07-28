<?php
namespace App\class;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Response;
trait Generic{

    private $entity=NULL;
    private string $twing='';

    protected function baseView(Registry $doctrine) : Response
    {
        $this->setData();
        $this->chcekData();
        $this->get_objects($doctrine);
        return $this->render($this->twing, [
            'object' => $this->get_objects($doctrine)
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

    private function get_objects(Registry $doctrine): array
    {
        $entityManager = $doctrine->getManager();
        return $this->preaper_query_set($entityManager);
    }

    private function preaper_query_set($entityManager)
    {
        return $this->on_query_set($entityManager->getRepository($this->entity));
    }
    
}