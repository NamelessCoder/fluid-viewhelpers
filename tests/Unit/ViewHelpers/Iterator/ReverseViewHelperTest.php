<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class ReverseViewHelperTest
 */
class ReverseViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     * @dataProvider getRenderTestValues
     * @param array $arguments
     * @param mixed $expectedValue
     */
    public function testRender(array $arguments, $expectedValue)
    {
        $this->assertEquals($this->executeViewHelper($arguments), $expectedValue);
    }

    /**
     * @return array
     */
    public function getRenderTestValues()
    {
        return [
            [['subject' => []], []],
            [['subject' => ['foo', 'bar']], [1 => 'bar', 0 => 'foo']],
            [['subject' => new \ArrayIterator(['foo', 'bar'])], [1 => 'bar', 0 => 'foo']],
        ];
    }

    /**
     * @test
     * @dataProvider getErrorTestValues
     * @param mixed $subject
     */
    public function testThrowsErrorsOnInvalidSubjectType($subject)
    {
        $this->expectViewHelperException();
        $this->executeViewHelper(['subject' => $subject]);
    }

    /**
     * @return array
     */
    public function getErrorTestValues()
    {
        return [
            [new \DateTime()],
            [new \stdClass()],
        ];
    }
}
