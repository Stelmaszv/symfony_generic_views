<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cars;

abstract class GenericListController extends AbstractController
{ 
    private string $controlerName='';
    private $entity=NULL;
    private string $twing='';

    protected function listView(ManagerRegistry $doctrine): Response
    {
        $this->setData();
        $this->chcekData();
        $this->get_objects($doctrine);
        return $this->render($this->twing, [
            'objects'=> $this->get_objects($doctrine)
        ]);
    }

    protected function on_query_set($entityManager) : array
    {
        return $entityManager->findAll();
    }

    private function preaper_query_set($entityManager) : array
    {
        return $this->on_query_set($entityManager->getRepository($this->entity));
    }

    private function get_objects(ManagerRegistry $doctrine): array
    {
        $entityManager = $doctrine->getManager();
        return $this->preaper_query_set($entityManager);
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

    abstract protected function setData(): void;

}
