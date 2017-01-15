<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Variable;

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use TYPO3Fluid\Fluid\Core\Variables\StandardVariableProvider;

/**
 * Class PregMatchViewHelperTest
 */
class PregMatchViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @test
     */
    public function testReturnsMatchesWithoutAsArgument()
    {
        $arguments = ['subject' => 'foobar', 'pattern' => '/[a-c]+/', 'global' => false];
        $instance = $this->buildViewHelperInstance();
        $matches = $instance::renderStatic($arguments, function() { return null; }, $this->getRenderingContext($instance));
        $this->assertSame(['ba'], $matches);
    }

    /**
     * @test
     */
    public function testReturnsMatchesWithGlobalWithoutAsArgument()
    {
        $arguments = ['subject' => 'foobar', 'pattern' => '/[a-c]+/', 'global' => true];
        $instance = $this->buildViewHelperInstance();
        $matches = $instance::renderStatic($arguments, function() { return null; }, $this->getRenderingContext($instance));
        $this->assertSame([['ba']], $matches);
    }

    /**
     * @test
     */
    public function testGetsSubjectFromTagContentWithoutSubjectArgumentAndAsArgument()
    {
        $arguments = ['subject' => null, 'pattern' => '/[a-c]+/', 'global' => false];
        $instance = $this->buildViewHelperInstance();
        $matches = $instance::renderStatic($arguments, function() { return 'foobar'; }, $this->getRenderingContext($instance));
        $this->assertSame(['ba'], $matches);
    }

    /**
     * @test
     */
    public function testAssignsMatchesAsTemplateVariablesWithAsArgument()
    {
        $arguments = ['subject' => 'foobar', 'as' => 'variable', 'pattern' => '/[a-c]+/', 'global' => false];
        $instance = $this->buildViewHelperInstance();
        $context = $this->getRenderingContext($instance);
        $matches = $instance::renderStatic
        ($arguments,
            function() use ($arguments, $context) {
                return $context->getVariableProvider()->get($arguments['as'])[0];
            },
            $context
        );
        $this->assertSame('ba', $matches);
    }
}
