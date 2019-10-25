<?php
declare(strict_types=1);

namespace Tests;

use Builder\BuilderException;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Occupation;
use Tests\Mock\Person;

class BuilderTest extends TestCase
{
    /**
     * @throws \Builder\BuilderException
     * @throws \ReflectionException
     */
    public function testBuilderObject()
    {
        $person = Person::buildAssoc([
            'name' => 'Guilherme Henrique Rodrigues',
            'age' => 24,
            'occupation' => Occupation::buildAssoc([
                'description' => 'Software Engineer'
            ])
        ]);

        $this->assertEquals(Person::class, get_class($person));
    }

    /**
     * @throws \Builder\BuilderException
     * @throws \ReflectionException
     */
    public function testBuilderObjectWithException()
    {
        $this->expectException(BuilderException::class);

        Person::buildAssoc([
            'name' => 'Guilherme Henrique Rodrigues',
            'age' => 24,
            'occupation' => 'Software Engineer'
        ]);

    }
}
