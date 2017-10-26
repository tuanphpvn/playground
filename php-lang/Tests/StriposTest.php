<?php

class StriposTest extends \PHPUnit\Framework\TestCase {
    public function testSimple() {
        $findMe = 'a';
        $string1 = 'xyz';
        $string2 = 'ABC';

        $this->assertTrue(stripos($string1, $findMe) === false);
        $this->assertTrue(stripos($string2, $findMe) === 0);
    }
}