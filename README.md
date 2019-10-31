# Hydrator :elephant: 

Trait that assists in the hydration of entities or classes that have the methods 'setters'

# Install
`composer require guil95/hidrate`

# Sample to use

```php
<?php
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
```

```php
<?php
//Sample build person
$person = Person::buildAssoc([
    'age' => 24,
    'name' => 'Guilherme Henrique Rodrigues',
    'occupation' => Occupation::buildAssoc([
        'description' => 'Software Engineer',
    ])
]);
```

# Tests

```
composer tests
```

# Tests and coverage
```
make test-report
```
