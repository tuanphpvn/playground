<?php

class ReflectionPropertyTest extends \PHPUnit\Framework\TestCase {

    public function testChangeRealClassThroughReflection() {

        $reflection = new \ReflectionProperty(Dummy::class, 'loaders');
        $reflection->setAccessible(true);
        $reflection->setValue(null, ['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], Dummy::getLoaders());

        Dummy::reset();

        $this->assertSame([], Dummy::getLoaders());
    }
}

class Dummy {
    static private $loaders = [];

    static public function getLoaders() {
        return self::$loaders;
    }

    static public function reset() {
        self::$loaders = [];
    }
}
