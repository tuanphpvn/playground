<?php
namespace Tests;
class ReflectionTest extends \PHPUnit\Framework\TestCase {
    public function testNameReflection() {

        $this->assertEquals('Tests\Hello', Hello::class);

        $reflectionClass = new \ReflectionClass(Hello::class);
        $this->assertEquals('Tests\Hello', $reflectionClass->getName());
    }
}

class Hello {

}