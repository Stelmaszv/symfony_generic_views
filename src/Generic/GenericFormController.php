<?php

namespace App\Generic;

use Symfony\Component\Form\Form;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form as SymfonyForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenericFormController extends AbstractController
{
    private array $sucess = [];
    private Request $request;
    protected ManagerRegistry $doctrine;
    protected string $form;
    
    use Generic;
    public function form(Request $request, ManagerRegistry $doctrine) : Response
    {  
        $this->doctrine=$doctrine;
        $this->request=$request;
        $this->setData();
        $this->chcekData();
        $form = $this->getForm($request)->handleRequest($request);

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

        return $this->render($this->twig, $this->addAttributes($form));
    }

    private function extuteSucessUrl() : RedirectResponse 
    {
        return $this->redirectToRoute($this->sucess['url'],$this->sucess['arguments']); 
    }

    private function chcekData() : void
    {
        if(!$this->form) {
            throw new \Exception("Form is not define in controller ".get_class($this)."!");
        }

        if(!$this->twig) {
            throw new \Exception("Twing is not define in controller ".get_class($this)."!");
        }
    }

    private function addAttributes(SymfonyForm $form) : array
    {
        $this->attributes = [
            'form'=> $form->createView()
        ];

        return array_merge($this->attributes, $this->onSetAttribut());
    }

    protected function getForm() : FormInterface
    {
        return $this->createForm($this->form);
    }

    protected function setForm(string $form) :void{
        $this->form= $form;
    }

    protected function setSucess(string $url,array $arguments) : void
    {
        $this->sucess['url'] = $url;
        $this->sucess['arguments'] = $arguments;
    }

    protected function onSetAttribut() : array
    {
        return [];
    }

    protected function onAfterValid(Form $form) : void{}

    protected function onBeforeValid() : void{}

    protected function onSubmittedTrue() : void{}

    protected function onSubmittedFalse() : void{}

    protected function onValid()  :void{}

    protected function onInValid() : void{}
}
