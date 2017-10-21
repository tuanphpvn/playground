<?php

/**
 *
 */
class A {
    public function sayHello() {
        echo "Hello";
    }
}

class B {
    public function sayWorld() {
        echo "World";
    }
}

class C {

    private $a;
    private $b;
    public function __construct(A $a, B $b) {
        $this->a = $a;
        $this->b = $b;

    }

    public function sayHelloWorld() {
        $this->a->sayHello();
        echo " ";
        $this->b->sayWorld();
    }
}

$class = new ReflectionClass('C');

$parameters = $class->getConstructor()->getParameters();

$classNames = [];
foreach($parameters as $i => $param) {
    $classNames[] = $param->getClass()->getName();
}

$intances = [];
foreach($classNames as $className) {
    $intances[] = new $className();
}

$newObject = $class->newInstance(...$intances);

$newObject->sayHelloWorld();


