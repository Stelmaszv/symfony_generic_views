<?php

namespace App\Generic;

use ReflectionClass;

trait EntityApiGeneric
{
    public function setApiGroup(ApiInterface $entityObject): ?array
    {
        $objectClassName = strtolower(basename(str_replace('\\', '/', get_class($entityObject))));
    
        if ($this->$objectClassName === null) {
            return null;
        }
    
        $values = [];
        $reflectionClass = new ReflectionClass($entityObject);
        $properties = $reflectionClass->getProperties();
    
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $getterMethod = 'get' . ucfirst($propertyName);
            $values[$propertyName] = $this->$objectClassName->$getterMethod();
        }
    
        return $values;
    }
}
