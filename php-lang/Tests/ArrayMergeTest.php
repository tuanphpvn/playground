<?php

class ArrayMergeTest extends \PHPUnit\Framework\TestCase {
    public function testSimple() {
        $a = ['k' => 'v', 'k1' => 'v1'];
        $b = ['bk' => 'bv', 'bk1' => 'bv1', 'k' => 'nv'];

        $c = array_merge($a, $b);

        $this->assertSame(['k' => 'nv', 'k1' => 'v1', 'bk' => 'bv', 'bk1' => 'bv1'], $c);
    }
}