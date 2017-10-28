<?php


class TouchTest extends \PHPUnit\Framework\TestCase {
    public function testSimple() {
        $time = time();
        $fileName = __DIR__.'/files/testtouch.txt';
        touch($fileName, $time);

        $this->assertSame($time, filemtime($fileName));
    }
}