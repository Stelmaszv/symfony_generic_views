<?php

namespace App\Generic\Web;

trait GenericGetTrait
{
    protected ?string $entity = null;
    protected ?string $twig = null;

    protected function beforeQuery() : void {}

    protected function afterQuery() : void{}

    protected function onSetAttribut() : array
    {
      return [];
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
}
