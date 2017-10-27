<?php

class ArrayMapTest extends \PHPUnit\Framework\TestCase {
    public function testTheFirstParamMustBeFunction() {
        $arr = array_map('strtoupper', ['hi', 'ho']);

        $this->assertEquals(['HI', 'HO'], $arr);
    }
}