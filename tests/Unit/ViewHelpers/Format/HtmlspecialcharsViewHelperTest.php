<?php
namespace TYPO3Fluid\Fluid\Tests\Unit\ViewHelpers\Format;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3\FluidViewHelpers\ViewHelpers\Format\HtmlspecialcharsViewHelper;

/**
 * Class HtmlspecialcharsViewHelperTest
 */
class HtmlspecialcharsViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @var HtmlspecialcharsViewHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $viewHelper;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->viewHelper = $this->getMockBuilder(HtmlspecialcharsViewHelper::class)->setMethods(['renderChildren'])->getMock();
    }

    /**
     * @test
     */
    public function viewHelperDeactivatesEscapingInterceptor()
    {
        $this->assertFalse($this->viewHelper->isOutputEscapingEnabled());
    }

    /**
     * @test
     */
    public function renderUsesValueAsSourceIfSpecified()
    {
        $this->viewHelper->expects($this->never())->method('renderChildren');
        $this->viewHelper->setArguments(
            ['value' => 'Some string', 'keepQuotes' => false, 'encoding' => 'UTF-8', 'doubleEncode' => false]
        );
        $actualResult = $this->viewHelper->initializeArgumentsAndRender();
        $this->assertEquals('Some string', $actualResult);
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            // render does not modify string without special characters
            [
                'value' => 'This is a sample text without special characters.',
                'options' => [],
                'expectedResult' => 'This is a sample text without special characters.'
            ],
            // render decodes simple string
            [
                'value' => 'Some special characters: &©"\'',
                'options' => [],
                'expectedResult' => 'Some special characters: &amp;©&quot;&#039;'
            ],
            // render respects "keepQuotes" argument
            [
                'value' => 'Some special characters: &©"',
                'options' => [
                    'keepQuotes' => true,
                ],
                'expectedResult' => 'Some special characters: &amp;©"'
            ],
            // render respects "encoding" argument
            [
                'value' => utf8_decode('Some special characters: &"\''),
                'options' => [
                    'encoding' => 'ISO-8859-1',
                ],
                'expectedResult' => 'Some special characters: &amp;&quot;&#039;'
            ],
            // render converts already converted entities by default
            [
                'value' => 'already &quot;encoded&quot;',
                'options' => [],
                'expectedResult' => 'already &amp;quot;encoded&amp;quot;'
            ],
            // render does not convert already converted entities if "doubleEncode" is FALSE
            [
                'value' => 'already &quot;encoded&quot;',
                'options' => [
                    'doubleEncode' => false,
                ],
                'expectedResult' => 'already &quot;encoded&quot;'
            ],
            // render returns unmodified source if it is a float
            [
                'value' => 123.45,
                'options' => [],
                'expectedResult' => 123.45
            ],
            // render returns unmodified source if it is an integer
            [
                'value' => 12345,
                'options' => [],
                'expectedResult' => 12345
            ],
            // render returns unmodified source if it is a boolean
            [
                'value' => true,
                'options' => [],
                'expectedResult' => true
            ],
        ];
    }

    /**
     * test
     *
     * @dataProvider dataProvider
     */
    public function renderTests($value, array $options, $expectedResult)
    {
        $options['value'] = $value;
        $this->viewHelper->setArguments($options);
        $this->assertSame($expectedResult, $this->viewHelper->initializeArgumentsAndRender());
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function renderTestsWithRenderChildrenFallback($value, array $options, $expectedResult)
    {
        $this->viewHelper->expects($this->any())->method('renderChildren')->will($this->returnValue($value));
        $options['value'] = null;
        $options['keepQuotes'] = (boolean) (isset($options['keepQuotes']) && $options['keepQuotes'] ? $options['keepQuotes'] : false);
        $options['encoding'] = 'UTF-8';
        $options['doubleEncode'] = (boolean) (isset($options['doubleEncode']) ? $options['doubleEncode'] : true);
        $this->viewHelper->setArguments($options);
        $this->assertSame($expectedResult, $this->viewHelper->initializeArgumentsAndRender());
    }
}
