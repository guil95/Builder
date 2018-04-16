<?php
namespace App\Traits;

trait Hidrate {
    public function populate(array $valores) {
        try {
            foreach ($valores as $atributo => $value) {
                $metodoSet = 'set' . ucfirst($atributo);
                if (method_exists($this, $metodoSet)) {
                        $this->$metodoSet($value);                    
                } else {
                    return false;
                   
                }
            }
        } catch (Exception $ex) {
            return false;
             
        }
        return true;

    }
}
