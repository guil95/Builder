<?php

trait Hidrate {
    public function populate(array $valores) {
        try {
            foreach ($valores as $atributo => $value) {
                $metodoSet = 'set' . ucfirst($atributo);
                if (!method_exists($this, $metodoSet)) {
                        return false;
                }
                $this->$metodoSet($value);
            }
        } catch (Exception $ex) {
            return false;
             
        }
        return true;

    }
}
