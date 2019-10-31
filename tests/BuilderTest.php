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
    public function testBuilderInvalidTypeParamException()
    {
        $this->expectException(BuilderException::class);

        Person::buildAssoc([
            'name' => 'Guilherme Henrique Rodrigues',
            'age' => 24,
            'occupation' => 'Software Engineer'
        ]);

    }

    /**
     * @throws BuilderException
     * @throws \ReflectionException
     */
    public function testBuilderNonExistentParam()
    {
        $person = Person::buildAssoc([
            'name' => 'Guilherme Henrique Rodrigues',
            'age' => 24,
            'occupation' => Occupation::buildAssoc([
                'description' => 'Software Engineer'
            ]),
            'phone' => 132456 //param nonexist in "Person" class
        ]);

        $this->assertEquals(Person::class, get_class($person));
    }

    /**
     * @throws BuilderException
     * @throws \ReflectionException
     */
    public function testBuilderInvalidTypeObjectException()
    {
        $this->expectException(BuilderException::class);

        Person::buildAssoc([
            'name' => 'Guilherme Henrique Rodrigues',
            'age' => 24,
            'occupation' => new \stdClass(),
            'phone' => 132456 //param nonexist in "Person" class
        ]);
    }

    /**
     * @throws BuilderException
     * @throws \ReflectionException
     */
    public function testBuilderRequiredParamException()
    {
        $this->expectException(BuilderException::class);

        Person::buildAssoc([
            'name' => 'Guilherme Henrique Rodrigues',
            'occupation' => Occupation::buildAssoc([
                'description' => 'Software Engineer'
            ])
        ]);
    }

    /**
     * @throws BuilderException
     * @throws \ReflectionException
     */
    public function testBuilderNotRequiredParam()
    {
       $person = Person::buildAssoc([
            'name' => 'Guilherme Henrique Rodrigues',
            'age' => 24
        ]);

        $this->assertEquals(Person::class, get_class($person));
    }
}
