<?php

namespace App\Generic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form as SymfonyForm;
use App\Forms\Car;

class GenericFormController extends AbstractController
{
    private string $form='';

    use Generic;
    public function form(Request $request): Response
    {
        $this->setData();
        $this->chcekData();
        $form = $this->createForm($this->form, null);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $this->onSubmittedTrue();
            if ($form->isValid()){
                $this->onValid();
            }else{
                $this->onInValid();
            }
        }else{
            $this->onSubmittedFalse();
        }
        return $this->render($this->twing, $this->addAttributes($form));
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

    protected function setForm(string $form){
        $this->form= $form;
    }

    protected function onSubmittedTrue():void{}

    protected function onSubmittedFalse():void{}

    protected function onValid():void{}

    protected function onInValid():void{}
}
