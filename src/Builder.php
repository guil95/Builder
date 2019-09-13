<?php

namespace Builder;

trait Builder
{

    /**
     * @param array $attributes
     * @return object
     * @throws \ReflectionException
     */
    public static function buildAssoc(array $attributes)
    {
        $reflector = new \ReflectionClass(self::class);

        $parametersToBuild = self::retrieveParametersToBuild($reflector, $attributes);

        return $reflector->newInstanceArgs($parametersToBuild);
    }

    /**
     * @param \ReflectionClass $reflector
     * @param array $attributes
     * @return array
     * @throws \Exception
     */
    private static function retrieveParametersToBuild(\ReflectionClass $reflector, array $attributes): array
    {
        $constructor = $reflector->getConstructor();

        $parameters = $constructor->getParameters();

        call_user_func([self::class, 'verifyRequiredParameters'], $attributes, $parameters);

        $parametersToBuild = [];

        foreach($parameters as $parameter) {
            if (!isset($attributes[$parameter->getName()])) {
                continue;
            }
            $attributeType = self::getType($attributes[$parameter->getName()]);

            if ($attributeType === 'object') {
                if ($parameter->getType() != null) {
                    $class = $parameter->getType()->getName();
                    if ($attributes[$parameter->getName()] instanceof $class) {
                        throw new \Exception(
                            sprintf('Invalid type from parameter %s', $parameter->getName())
                        );
                    }
                }
            }

            if ($parameter->getType() != null && $attributeType!== $parameter->getType()->getName()) {
                throw new \Exception(
                    sprintf('Invalid type from parameter %s', $parameter->getName())
                );
            }

            $parametersToBuild[$parameter->getPosition()] = $attributes[$parameter->getName()];
        }

        return $parametersToBuild;
    }

    /**
     * @param mixed $var
     * @return string
     */
    private static function getType($var): string
    {
        if (gettype($var) === 'integer') {
            return 'int';
        }

        return gettype($var);
    }

    private function verifyRequiredParameters(array $attributes, array $parameters)
    {
        foreach ($parameters as $parameter) {
            /**
             * @var $parameter \ReflectionParameter
             */
            if (!$parameter->isOptional() && !isset($attributes[$parameter->getName()])) {
                throw new \Exception(
                    sprintf('The parameter %s is required', $parameter->getName())
                );
            }
        }
    }
}
