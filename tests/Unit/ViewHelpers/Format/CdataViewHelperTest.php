<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Format;

/*
 * This file belongs to the package "TYPO3/FluidViewHelpers".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3\FluidViewHelpers\ViewHelpers\Format\CdataViewHelper;

/**
 * Class CdataViewHelperTest
 */
class CdataViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @param array $arguments
     * @param string|NULL $tagContent
     * @param string $expected
     * @dataProvider getRenderTestValues
     */
    public function testRender($arguments, $tagContent, $expected)
    {
        $instance = new CdataViewHelper();
        $instance->setArguments($arguments);
        $instance->setRenderingContext($this->getMockBuilder(RenderingContext::class)->disableOriginalConstructor()->getMock());
        $instance->setRenderChildrenClosure(function () use ($tagContent) {
            return $tagContent;
        });
        $this->assertEquals($expected, $instance->initializeArgumentsAndRender());
    }

    /**
     * @return array
     */
    public function getRenderTestValues()
    {
        return [
            [[], 'test1', '<![CDATA[test1]]>'],
            [['value' => 'test2'], null, '<![CDATA[test2]]>'],
        ];
    }
}
