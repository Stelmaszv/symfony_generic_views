<?php

namespace App\Generic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form as SymfonyForm;
use Doctrine\Persistence\ManagerRegistry;

class GenericFormController extends AbstractController
{
    protected string $form='';
    private array $sucess = [];
    
    use Generic;
    public function form(Request $request,ManagerRegistry $doctrine): Response
    {  
        $this->doctrine=$doctrine;
        $this->request=$request;
        $this->setData();
        $this->chcekData();
        $form=$this->getForm($request)->handleRequest($request);

        if ($form->isSubmitted()){
            $this->onSubmittedTrue();
            if ($form->isValid()){
                $this->onBeforeValid();
                $this->onValid();
                $this->onAfterValid($form);
                if ($this->sucess){
                    return $this->extuteSucessUrl();
                }
            }else{
                $this->onInValid();
            }
        }else{
            $this->onSubmittedFalse();
        }

        return $this->render($this->twing, $this->addAttributes($form));
    }

    private function extuteSucessUrl(){
        return $this->redirectToRoute($this->sucess['url'],$this->sucess['arguments']); 
    }

    private function chcekData() :void
    {
        if(!$this->form) {
            throw new \Exception("form is not define in controller ".get_class($this)."!");
        }

        if(!$this->twing) {
            throw new \Exception("Twing is not define in controller ".get_class($this)."!");
        }
    }

    private function addAttributes(SymfonyForm $form) :array
    {
        
        $this->attributes = [
            'form'=> $form->createView()
        ];

        return array_merge($this->attributes, $this->onSetAttribut());
    }

    protected function getForm(){
        return $this->createForm($this->form);
    }

    protected function setForm(string $form){
        $this->form= $form;
    }

    protected function setSucess(string $url,array $arguments){
        $this->sucess['url'] = $url;
        $this->sucess['arguments'] = $arguments;
    }

    protected function onSetAttribut():array
    {
        return [];
    }

    protected function onAfterValid($form){}

    protected function onBeforeValid():void{}

    protected function onSubmittedTrue():void{}

    protected function onSubmittedFalse():void{}

    protected function onValid():void{}

    protected function onInValid():void{}
}
