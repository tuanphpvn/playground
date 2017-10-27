<?php

class ReferenceTest extends \PHPUnit\Framework\TestCase {
    public function testSimple() {
        $a = new Foo;

        $b = $a;

        $c = &$a;

        $this->assertSame($a, $b);
        $this->assertSame($c, $a);
        $this->assertSame($c, $b);

    }

    public function testWhenPointToNewObject() {
        $a = new Foo;

        $b = $a;

        $c = &$a;

        $b =new Bar();

        $this->assertNotSame($a, $b);
        $this->assertSame($c, $a);
        $this->assertNotSame($c, $b);
    }

    public function testRemoveReference() {
        $a = new MyClass();
        $b = $a;

        $this->assertSame($a, $b);

        $a->inc();
        $this->assertTrue(2 === $a->var );
        $b->inc();
        $this->assertTrue(3 === $b->var );

        $c = &$a;
        $a = null;
        $this->assertSame(null, $c);

        $b = null; // So no reference point to MyClass. The entityMyClass in memory will be collected by collector.
    }

    public function testSpecial() {
        $a = '1';
        $b = &$a;
        $b = "2$b";

        $this->assertSame("21", $b);
        $this->assertSame("21", $a);
    }
}

class Foo {

}

class Bar {

}

class MyClass {
    public $var;

    function __construct() {
        $this->var = 1;
    }

    function inc() { return ++$this->var; }

}
