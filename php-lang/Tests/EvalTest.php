<?php

class EvalTest extends \PHPUnit\Framework\TestCase {
    public function testCreate10Class() {
        for($i = 0; $i < 10; $i++) {
            $className = 'MyClass_' . $i ;
            eval('class ' . $className . ' {}' );
        }

        for($i =0; $i < 10; $i++) {
            $className = 'MyClass_' . $i;
            $this->assertTrue(class_exists($className));
        }
    }
}