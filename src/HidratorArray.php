<?php

namespace Hidrator;

trait HidratorArray {
    /**
     * @param array $attributes
     */
    public function hidrate(array $attributes) {
        foreach ($attributes as $attr => $value) {
            $methodSet = 'set' . ucfirst($attr);
            if (method_exists($this, $methodSet)) {
                $this->{$methodSet}($value);
            }
        }
    }
}
