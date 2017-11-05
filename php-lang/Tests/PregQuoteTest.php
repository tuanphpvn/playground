<?php

class PregQuoteTest extends \PHPUnit\Framework\TestCase {
    public function testSimple() {
        $keywords = '$40 for a g3/400';
        $keywords = preg_quote($keywords, '/');

        $this->assertEquals('\$40 for a g3\/400', $keywords);

        $textbody = "This book is *very* difficult to find.";
        $word = "*very*";
        $textbody = preg_replace ("/" . preg_quote($word, '/') . "/",
            "<i>" . $word . "</i>",
            $textbody);

        $this->assertEquals('This book is <i>*very*</i> difficult to find.', $textbody);
    }
}