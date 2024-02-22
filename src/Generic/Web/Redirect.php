<?php

namespace App\Generic\Web;

class Redirect
{
    private ?string $name = null;
    private ?array $attributes = null;

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function isRedirect() : bool{
        return (($this->name !== null) && ($this->attributes !== null));
    }

    /**
     * @return  self
     */ 
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }
}
