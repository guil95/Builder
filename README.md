# Hidrator :elephant: :cup_with_straw:

Trait that assists in the hydration of entities or classes that have the methods 'setters'

# Install
`composer require guil95/hidrate`

# Sample to use

```
//Entity class
<?php
  namespace App\Entity;
  
  use Hidrator\Hidrator;
  
  class Person{
  
    use Hidrator;
    
    private $name;
    
    public function setName(string $name)
    {
      $this->name = $name;
    }
  }
```

```
//Repository class
<?php
  namespace App\Repository;
  
  use App\Entity\Person;
  
  class PersonRepository{

    public function save()
    {
      $person = new Person();
      $person->hidrate([
        'name' => 'Guilherme'
      ]);
    }
  }
```
