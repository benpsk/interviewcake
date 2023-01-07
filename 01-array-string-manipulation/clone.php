<?php

class MyClass
{
    public $first_name = 'John';
    public $last_name = 'Doe';

    public function __construct()
    {
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }
}


$my = new MyClass();

$my->first_name = 'Ben';

// $copy = $my;
$copy = clone $my;

$copy->first_name = "ok";


echo $my->getFullName() . PHP_EOL;
echo $copy->getFullName() . PHP_EOL;
