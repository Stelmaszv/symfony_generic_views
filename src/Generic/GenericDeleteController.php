<?php

namespace App\Generic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Generic\Generic;
use App\Entity\Cars;
use Doctrine\Persistence\ManagerRegistry as SymRegistry;

class GenericDeleteController extends AbstractController
{
    use Generic;
    public function Delete(SymRegistry $doctrine,int $id): Response
    {
        $this->setData();
        $data=$doctrine->getManager()->getRepository($this->getEntity())->find($id); 
        $entityManager = $doctrine->getManager();
        $this->onAfterBefore();
        $entityManager->remove($data);
        $entityManager->flush();
        $this->onAfterDelete();
        if ($this->sucess){
            return $this->extuteSucessUrl();
        }
    }

    protected function setSucess(string $url,array $arguments=[]){
        $this->sucess['url']=$url;
        $this->sucess['arguments']=$arguments;
    }

    private function extuteSucessUrl(){
        return $this->redirectToRoute($this->sucess['url'],$this->sucess['arguments']); 
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
