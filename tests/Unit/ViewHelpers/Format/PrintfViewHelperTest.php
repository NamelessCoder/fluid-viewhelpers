<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Format;

/*
 * This file belongs to the package "TYPO3/FluidViewHelpers".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3\FluidViewHelpers\ViewHelpers\Format\PrintfViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;

/**
 * Class PrintfViewHelperTest
 */
class PrintfViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @var \TYPO3Fluid\Fluid\ViewHelpers\Format\PrintfViewHelper
     */
    protected $viewHelper;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->viewHelper = $this->getMockBuilder(PrintfViewHelper::class)->setMethods(['renderChildren'])->getMock();
        $this->viewHelper->setRenderingContext($this->getMockBuilder(RenderingContext::class)->disableOriginalConstructor()->getMock());
    }

    /**
     * @test
     */
    public function viewHelperCanUseArrayAsArgument()
    {
        $this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue('%04d-%02d-%02d'));
        $this->viewHelper->setArguments(['value' => null, 'arguments' => ['year' => 2009, 'month' => 4, 'day' => 5]]);
        $actualResult = $this->viewHelper->initializeArgumentsAndRender();
        $this->assertEquals('2009-04-05', $actualResult);
    }

    /**
     * @test
     */
    public function viewHelperCanSwapMultipleArguments()
    {
        $this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue('%2$s %1$d %3$s %2$s'));
        $this->viewHelper->setArguments(['value' => null, 'arguments' => [123, 'foo', 'bar']]);
        $actualResult = $this->viewHelper->initializeArgumentsAndRender();
        $this->assertEquals('foo 123 bar foo', $actualResult);
    }
}
