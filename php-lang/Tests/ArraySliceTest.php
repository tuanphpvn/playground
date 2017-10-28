<?php

class ArraySliceTest extends \PHPUnit\Framework\TestCase {
    public function testLengthNotOffset() {
        $a = [1,2,3];
        $as = array_slice($a, 0, 1);

        $this->assertNotEquals([1,2], $as);
        $this->assertEquals([1], $as);
    }
}