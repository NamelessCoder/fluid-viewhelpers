<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Format;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class EliminateViewHelperTest
 */
class EliminateViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @var array
     */
    protected $arguments = [
        'caseSensitive' => true,
        'characters' => null,
        'strings' => null,
        'whitespace' => false,
        'tabs' => false,
        'unixBreaks' => false,
        'windowsBreaks' => false,
        'digits' => false,
        'letters' => false,
        'nonAscii' => false
    ];

    /**
     * @test
     */
    public function removesNonAscii()
    {
        $arguments = $this->arguments;
        $arguments['nonAscii'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], 'fooøæåbar');
        $this->assertSame('foobar', $test);
    }

    /**
     * @test
     */
    public function removesLetters()
    {
        $arguments = $this->arguments;
        $arguments['letters'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], 'foo123bar');
        $this->assertSame('123', $test);
    }

    /**
     * @test
     */
    public function removesLettersRespectsCaseSensitive()
    {
        $arguments = $this->arguments;
        $arguments['letters'] = true;
        $arguments['caseSensitive'] = false;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], 'FOO123bar');
        $this->assertSame('123', $test);
    }

    /**
     * @test
     */
    public function removesDigits()
    {
        $arguments = $this->arguments;
        $arguments['digits'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], 'foo123bar');
        $this->assertSame('foobar', $test);
    }

    /**
     * @test
     */
    public function removesWindowsCarriageReturns()
    {
        $arguments = $this->arguments;
        $arguments['windowsBreaks'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], "breaks\rbreaks");
        $this->assertSame('breaksbreaks', $test);
    }

    /**
     * @test
     */
    public function removesUnixBreaks()
    {
        $arguments = $this->arguments;
        $arguments['unixBreaks'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], "breaks\nbreaks");
        $this->assertSame('breaksbreaks', $test);
    }

    /**
     * @test
     */
    public function removesTabs()
    {
        $arguments = $this->arguments;
        $arguments['tabs'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], 'tabs	tabs');
        $this->assertSame('tabstabs', $test);
    }

    /**
     * @test
     */
    public function removesWhitespace()
    {
        $arguments = $this->arguments;
        $arguments['whitespace'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], ' trimmed ');
        $this->assertSame('trimmed', $test);
    }

    /**
     * @test
     */
    public function removesWhitespaceBetweenHtmlTags()
    {
        $arguments = $this->arguments;
        $arguments['whitespaceBetweenHtmlTags'] = true;
        $test = $this->executeViewHelperUsingTagContent($arguments, [], ' <p> Foo </p> <p> Bar </p> ');
        $this->assertSame('<p> Foo </p><p> Bar </p>', $test);
    }

    /**
     * @test
     */
    public function removesCharactersRespectsCaseSensitive()
    {
        $arguments = $this->arguments;
        $arguments['characters'] = 'abc';
        $arguments['caseSensitive'] = false;
        $result = $this->executeViewHelperUsingTagContent($arguments, [], 'ABCdef');
        $this->assertSame('def', $result);
    }

    /**
     * @test
     */
    public function removesCharactersAsString()
    {
        $arguments = $this->arguments;
        $arguments['characters'] = 'abc';
        $result = $this->executeViewHelperUsingTagContent($arguments, [], 'abcdef');
        $this->assertSame('def', $result);
    }

    /**
     * @test
     */
    public function removesCharactersAsArray()
    {
        $arguments = $this->arguments;
        $arguments['characters'] = ['a', 'b', 'c'];
        $result = $this->executeViewHelperUsingTagContent($arguments, [], 'abcdef');
        $this->assertSame('def', $result);
    }

    /**
     * @test
     */
    public function removesStringsRespectsCaseSensitive()
    {
        $arguments = $this->arguments;
        $arguments['strings'] = 'abc,def,ghi';
        $arguments['caseSensitive'] = false;
        $result = $this->executeViewHelperUsingTagContent($arguments, [], 'aBcDeFgHijkl');
        $this->assertSame('jkl', $result);
    }

    /**
     * @test
     */
    public function removesStringsAsString()
    {
        $arguments = $this->arguments;
        $arguments['strings'] = 'abc,def,ghi';
        $result = $this->executeViewHelperUsingTagContent($arguments, [], 'abcdefghijkl');
        $this->assertSame('jkl', $result);
    }

    /**
     * @test
     */
    public function removesStringsAsArray()
    {
        $arguments = $this->arguments;
        $arguments['strings'] = ['abc', 'def', 'ghi'];
        $result = $this->executeViewHelperUsingTagContent($arguments, [], 'abcdefghijkl');
        $this->assertSame('jkl', $result);
    }
}
