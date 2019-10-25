<?php
declare(strict_types=1);

namespace Tests\Mock;

use Builder\Builder;

class Person
{
    use Builder;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Occupation
     */
    private $occupation;

    public function __construct(string $name, int $age, Occupation $occupation)
    {
        $this->age = $age;
        $this->name = $name;
        $this->occupation = $occupation;
    }
}
