<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Variable;

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3Fluid\Fluid\Core\Variables\StandardVariableProvider;

/**
 * Class UnsetViewHelperTest
 */
class UnsetViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     */
    public function testUnsetsVariableInVariableProvider()
    {
        $arguments = ['name' => 'variable'];
        $instance = $this->buildViewHelperInstance();
        $context = $this->getRenderingContext($instance);
        $variableProvider = $this->getMockBuilder(StandardVariableProvider::class)->setMethods(['exists', 'remove'])->getMock();
        $variableProvider->expects($this->once())->method('exists')->with('variable')->willReturn(true);
        $variableProvider->expects($this->once())->method('remove')->with('variable');
        $context->setVariableProvider($variableProvider);
        $instance::renderStatic($arguments, function() { return null; }, $context);
    }
}
