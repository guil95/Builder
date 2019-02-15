<?php

trait Hidrator {
    public function hidrate(array $values) {
        foreach ($values as $attr => $value) {
            $methodSet = 'set' . ucfirst($attr);
            if (method_exists($this, $methodSet)) {
                $this->{$methodSet}($value);
            }
        }
    }
}
