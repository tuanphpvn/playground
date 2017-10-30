1<?php

class PregSplitTest extends \PHPUnit\Framework\TestCase
{
    public function testSimple()
    {


        $keywords = preg_split('/[\s,]+/', "hypertext language, programming");

        $this->assertEquals(['hypertext', 'language', 'programming'], $keywords);

        $str = 'string';
        $chars = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
        $this->assertSame(['s', 't', 'r', 'i', 'n', 'g'], $chars);

        $chars = preg_split('//', $str, -1);
        $this->assertNotSame(['s', 't', 'r', 'i', 'n', 'g'], $chars);
        $this->assertSame(['', 's', 't', 'r', 'i', 'n', 'g', ''], $chars);

        $str = 'hypertext language programming';
        $chars = preg_split('/ /', $str, -1, PREG_SPLIT_OFFSET_CAPTURE);
        $this->assertSame([
            [
                'hypertext',
                0
            ],
            [
                'language',
                10
            ],
            [
                'programming',
                19
            ]
        ], $chars);


    }

    public function testWithDelimCapture()
    {

        $content = '<strong>Lorem ipsum dolor</strong> sit <img src="test.png" />amet <span class="test" style="color:red">consec<i>tet</i>uer</span>.';
        $chars = preg_split('/<[^>]*[^\/]>/i', $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $this->assertEquals([
            'Lorem ipsum dolor',
            ' sit <img src="test.png" />amet ',
            'consec',
            'tet',
            'uer',
            '.'
        ], $chars);
    }

    public function testKeepDelimeterPattern()
    {
        $content = '<strong>Lorem ipsum dolor</strong> sit <img src="test.png" />amet <span class="test" style="color:red">consec<i>tet</i>uer</span>.';
        $chars = preg_split('/(<[^>]*[^\/]>)/i', $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $this->assertEquals([
            '<strong>',
            'Lorem ipsum dolor',
            '</strong>',
            ' sit <img src="test.png" />amet ',
            '<span class="test" style="color:red">',
            'consec',
            '<i>',
            'tet',
            '</i>',
            'uer',
            '</span>',
            '.'
        ], $chars);
    }

    public function testToken()
    {
        $regex = '/([a-z_\\\][a-z0-9_\:\\\]*[a-z_][a-z0-9_]*)|((?:[+-]?[0-9]+(?:[\.][0-9]+)*)(?:[eE][+-]?[0-9]+)?)|("(?:""|[^"])*+")|\s+|\*+|(.)/i';
        $input = '@AnnotationWithConstants(PHP_EOL, ClassWithConstants::SOME_VALUE, ClassWithConstants::CONSTANT_, ClassWithConstants::CONST_ANT3, \Doctrine\Tests\Common\Annotations\Fixtures\InterfaceWithConstants::SOME_VALUE)';

        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
        $matches = preg_split($regex, $input, -1, $flags);

        $this->assertEquals($tokens = array(
            array(
                 '@',
                 0,
            ),
            array(
                 'AnnotationWithConstants',
                 1,
            ),
            array(
                 '(',
                24,
            ),
            array(
                'PHP_EOL',
                25,
            ),
            array(
                ',',
                32,
            ),
            array(
                'ClassWithConstants::SOME_VALUE',
                34,
            ),
            array(
                ',',
                 64,
            ),
            array(
                'ClassWithConstants::CONSTANT_',
                 66,
            ),
            array(
                ',',
                95,
            ),
            array(
                'ClassWithConstants::CONST_ANT3',
                97,
            ),
            array(
                ',',
                 127,
            ),
            array(
                '\\Doctrine\\Tests\\Common\\Annotations\\Fixtures\\InterfaceWithConstants::SOME_VALUE',
                129,
            ),
            array(
                ')',
                207,
            )

        )
            , $matches);

        $input = '@Foo("""' . "\n" . '""")';

        $regex = '/("(?:""|[^"])*+")/';
        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
        $matches = preg_split($regex, $input, -1, $flags);

        $this->assertEquals([
            [
                '@Foo(',
                0
            ],
            [
                '"""' ."\n". '"""',
                5
            ],
            [
                ')',
                12
            ]
        ], $matches);

    }
}