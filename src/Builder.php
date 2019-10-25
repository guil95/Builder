<?php

namespace Builder;

trait Builder
{

    /**
     * @param array $attributes
     * @return object
     * @throws BuilderException
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
     * @throws BuilderException
     */
    private static function retrieveParametersToBuild(\ReflectionClass $reflector, array $attributes): array
    {
        $parameters = $reflector->getConstructor()->getParameters();

        call_user_func([self::class, 'verifyRequiredParameters'], $attributes, $parameters);

        $parametersToBuild = [];

        foreach($parameters as $parameter) {
            if (!isset($attributes[$parameter->getName()])) {
                continue;
            }

            if (is_object($attributes[$parameter->getName()])) {
                if ($parameter->getType() != null) {
                    $class = $parameter->getType()->getName();
                    if (get_class($attributes[$parameter->getName()]) !== $class) {
                        throw new BuilderException(
                            sprintf('Invalid type from parameter %s', $parameter->getName())
                        );
                    }
                }
            }

            if (!is_object($attributes[$parameter->getName()])) {
                if (
                    $parameter->getType() != null
                    && self::getType($attributes[$parameter->getName()]) !== $parameter->getType()->getName()
                ) {
                    throw new BuilderException(
                        sprintf('Invalid type from parameter %s', $parameter->getName())
                    );
                }
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

    /**
     * @param array $attributes
     * @param array $parameters
     * @throws BuilderException
     */
    private function verifyRequiredParameters(array $attributes, array $parameters)
    {
        foreach ($parameters as $parameter) {
            /**
             * @var $parameter \ReflectionParameter
             */
            if (!$parameter->isOptional() && !isset($attributes[$parameter->getName()])) {
                throw new BuilderException(
                    sprintf('The parameter %s is required', $parameter->getName())
                );
            }
        }
    }
}
