<?php
class YieldTest extends \PHPUnit\Framework\TestCase {
    public function testSimpleCase() {
        function generate_one_to_three() {
            for($i =0; $i < 3; $i++) {
                yield $i;
            }
        }

        $generator = generate_one_to_three();

        $i = 0;
        foreach($generator as $value) {
            $this->assertEquals($i, $value); // $i = 0, 1, 2
            $i = $i+1;
        }
    }

    public function testWithAssociateArray() {
        $input = <<<'EOT'
1;PHP;Likes dollar sign
2;Python;Likes whitespace
3;Ruby;Like blocks
EOT;
        function input_parse($input) {
            foreach(explode("\n", $input) as $line) {
                $arrElement = explode(";", $line);
                $id = array_shift($arrElement);
                yield $id => $arrElement;

            }
        }

        $arrId = [];
        foreach(input_parse($input) as $id => $value) {
            $arrId[] = $id;
        }

        $this->assertEquals([0 =>1, 1=> 2,2 => 3], $arrId);

    }
}