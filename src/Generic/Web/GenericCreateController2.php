<?php
namespace App\Generic\Web;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use App\Generic\Web\GenericFormController;

class GenericCreateController2
{
    private int $inserdId;
    private object $entityClass; 

    protected function getForm() : FormInterface
    {
        $this->entityClass = new $this->entity();
        return $this->createForm($this->form,$this->entityClass);
    }

    protected function onAfterValid(Form $form) : void
    {
        $this->onBeforeSave();
        $em = $this->doctrine->getManager();
        $em->persist($this->entityClass);
        $em->flush();
        $this->inserdId = $this->entityClass->getId();
        $this->onAfterSaveSave();
    }

    protected function createdUrl(string $url) : void
    {
       $this->setSucess(
            $url,[
                'id' => $this->inserdId
            ]
        );
    }

    protected function onAfterSaveSave() : void {}

    protected function onBeforeSave() : void {}

    public function setData() : void {}
}
