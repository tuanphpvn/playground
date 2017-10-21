<?php

/**
 *
 */
class A {

}

class B {

}

class AA {
    public function __construct(A $a) {

    }

    public function sayHello() {
        echo "Hello";
    }
}

class BB {
    public function __construct(B $b) {

    }

    public function sayWorld() {
        echo "World";
    }
}

class C {

    private $a;
    private $b;
    public function __construct(AA $a, BB $b) {
        $this->a = $a;
        $this->b = $b;

    }

    public function sayHelloWorld() {
        $this->a->sayHello();
        echo " ";
        $this->b->sayWorld();
    }
}


function newInstance($className) {
    $class = new ReflectionClass($className);

    $objConstructor = $class->getConstructor();
    if(!$objConstructor) {
        return new $className();
    }

    $parameters = $objConstructor->getParameters();

    $classNames = [];
    foreach($parameters as $i => $param) {
        $classNames[] = $param->getClass()->getName();
    }

    $intances = [];
    foreach($classNames as $className) {
        $intances[] = newInstance($className);
    }

    return $class->newInstance(...$intances);
}

$newObject = newInstance("C");
$newObject->sayHelloWorld();


