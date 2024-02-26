<?php

namespace App\Generic\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenericFormController extends AbstractController
{
    private FormFactoryInterface $formFactory;
    private Request $request;
    protected Redirect $redirect;
    protected Flash $flash;
    protected string $form;
    protected string $twig;

    public function __invoke(FormFactoryInterface $formFactory, Request $request): Response
    {
        $this->chcekData();
        $this->initialize($formFactory, $request);
        $this->redirect = new Redirect();
        $this->flash = new Flash($this);

        return $this->formAction();
    }

    protected function initialize(FormFactoryInterface $formFactory, Request $request): void
    {
        $this->formFactory = $formFactory;
        $this->request = $request;
    }
    
   public function formAction() : Response
   {
       $form = $this->formFactory->create($this->form);
       $form->handleRequest($this->request);

        if ($form->isSubmitted()){
            $this->onSubmittedTrue();
            $this->onBeforeValid();
            if ($form->isValid()){
                $this->onValid();
                $this->onAfterValid();
            }else{
                $this->onInValid();
            }
        }else{
            $this->onSubmittedFalse();
        }

       return $this->render($this->twig, $this->getAttributes());
   }

   protected function onSetAttribute() : array
   {
        return [];
   }

   private function getAttributes(): array
   {
       $attributes['form'] = $this->setFormToAttribute();

       return array_merge($attributes, $this->onSetAttribute());
   }

   private function setFormToAttribute(){
        $form = $this->formFactory->create($this->form);
        $form->handleRequest($this->request);

        return $form->createView();
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

   protected function onSubmittedTrue() : void {}
   protected function onSubmittedFalse() : void {}
   protected function onValid()  :void {}
   protected function onInValid() : void {}
   protected function onBeforeValid() : void {}
   protected function onAfterValid() : void {}
}
