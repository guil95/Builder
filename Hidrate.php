<?php

trait Hidrate {
    public function populate(array $valores) {
        foreach ($valores as $atributo => $value) {
            $metodoSet = 'set' . ucfirst($atributo);
            if (method_exists($this, $metodoSet)) {
                $this->{$metodoSet}($value);
            }
        }
    }
}
