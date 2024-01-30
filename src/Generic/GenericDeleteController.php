<?php

namespace App\Generic;

use App\Generic\Generic;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry as SymRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenericDeleteController extends AbstractController implements GenericSetDataInterFace
{
    use Generic;
    private array $sucess = [];

    public function delete(SymRegistry $doctrine,int $id): Response
    {
        $this->setData();

        $data = $doctrine->getManager()->getRepository($this->getEntity())->find($id);
    
        if (!$data) {
            return new Response('Object not found.', 404);
        }
    
        $entityManager = $doctrine->getManager();
        $this->onAfterBefore();
        $entityManager->remove($data);
        $entityManager->flush();
        $this->onAfterDelete();
    
        if ($this->sucess) {
            return $this->extuteSucessUrl();
        }
    
        return new Response('Object was destroyed!');
    }

    public function setData(): void {}

    private function extuteSucessUrl(){
        return $this->redirectToRoute($this->sucess['url'],$this->sucess['arguments']);
    }

    protected function setSucess(string $url,array $arguments=[]){
        $this->sucess['url']=$url;
        $this->sucess['arguments']=$arguments;
    }

    private function chcekData() :void
    {
        if(!$$this->entity) {
            throw new \Exception("form is not define in controller ".get_class($this)."!");
        }
    }

    protected function onAfterBefore():void{}

    protected function onAfterDelete():void{}
}
