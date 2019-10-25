<?php
declare(strict_types=1);

namespace Tests\Mock;

use Builder\Builder;

class Occupation
{
    use Builder;

    /**
     * @var string
     */
    private $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }
}
