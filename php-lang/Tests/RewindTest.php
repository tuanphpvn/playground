<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPUnit\Framework;

class RewindTest extends TestCase
{

    public function testFirst() {
        $this->assertTrue(true, "Fail test first -> Make it success");
    }

    public function testRewind() {

        $outputFile = __DIR__.'/files/output.txt';
        $handle = fopen($outputFile, 'r+');

        fwrite($handle, "Really long sentence");
        rewind($handle);
        fwrite($handle, 'Foo');
        rewind($handle);

        $this->assertEquals("Foolly long sentence", fread($handle, filesize($outputFile)));
    }


}

