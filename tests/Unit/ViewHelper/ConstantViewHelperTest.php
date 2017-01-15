<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers;

/**
 * Class ConstantViewHelperTest
 */
class ConstantViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @return void
     */
    public function testReturnsConstantValue()
    {
        $result = $this->executeViewHelper(['name' => 'PHP_EOL']);
        $this->assertEquals(PHP_EOL, $result);
    }
}
