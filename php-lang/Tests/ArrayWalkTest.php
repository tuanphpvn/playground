<?php

class ArrayWalkTest extends \PHPUnit\Framework\TestCase {
    public function testSimple() {
        $arr = [1,2,3];

        array_walk($arr, function(&$value) {
            $value *= 2;
        });

        $this->assertEquals([2,4,6], $arr);
    }
}