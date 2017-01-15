<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers;

/**
 * Class UnlessViewHelperTest
 */
class UnlessViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @test
     */
    public function testRendersThenOnEvaluationFalse()
    {
        $result = $this->executeViewHelper(['condition' => false, 'then' => 'then']);
        $this->assertSame('then', $result);
    }

    /**
     * @test
     */
    public function testRendersNullOnEvaluationTrue()
    {
        $result = $this->executeViewHelper(['condition' => true, 'then' => 'then']);
        $this->assertEmpty($result);
    }

}
