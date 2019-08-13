<?php

namespace Hidrator;


trait Hidrator
{
    /**
     * @param array $attributes
     * @throws \ReflectionException
     */
    public function buildAssoc(array $attributes)
    {
        $reflector = new \ReflectionClass($this);

        $properties = $reflector->getProperties();

        foreach($properties as $property) {
            $p = $reflector->getProperty($property->getName());

            $p->setAccessible(true);

            if (in_array($property->getName(), array_keys($attributes))) {
                $p->setValue($this, $attributes[$property->getName()]);
            }
        }
    }
}
