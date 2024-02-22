<?php

namespace App\Generic\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Flash
{
    private AbstractController $controller;
    private ?string $type;
    private ?string $message;

    function __construct(AbstractController $controller)
    {
        $this->controller = $controller;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function isFlash() : bool
    {
        return (($this->type !== null) && ($this->message !== null));
    }
}
