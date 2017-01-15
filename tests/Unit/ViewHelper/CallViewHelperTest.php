<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers;

/**
 * Class CallViewHelperTest
 */
class CallViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @test
     */
    public function throwsRuntimeExceptionIfObjectNotFound()
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionCode(1356849652);
        $this->executeViewHelper(['method' => 'method', 'arguments' => []]);
    }

    /**
     * @test
     */
    public function throwsRuntimeExceptionIfMethodNotFound()
    {
        $object = new \ArrayIterator(['foo', 'bar']);
        $this->expectException('RuntimeException');
        $this->expectExceptionCode(1356834755);
        $this->executeViewHelper(['method' => 'notfound', 'object' => $object, 'arguments' => []]);
    }

    /**
     * @test
     */
    public function executesMethodOnObjectFromArgument()
    {
        $object = new \ArrayIterator(['foo', 'bar']);
        $result = $this->executeViewHelper(['method' => 'count', 'object' => $object, 'arguments' => []]);
        $this->assertEquals(2, $result);
    }

    /**
     * @test
     */
    public function executesMethodOnObjectFromChildContent()
    {
        $object = new \ArrayIterator(['foo', 'bar']);
        $result = $this->executeViewHelperUsingTagContent(['method' => 'count', 'arguments' => []], [], $object);
        $this->assertEquals(2, $result);
    }
}
