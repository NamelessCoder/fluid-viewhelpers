<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Variable;

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class EnvironmentViewHelperTest
 */
class EnvironmentViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     */
    public function testReadsDefinedEnvironmentVariable()
    {
        putenv('TEST=test');
        $arguments = ['name' => 'TEST'];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals(getenv('TEST'), $result);
    }
}
