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
 * Class PushViewHelperTest
 */
class PushViewHelperTest extends AbstractViewHelperTestCase
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
            [['subject' => ['foo', 'bar'], 'add' => 'baz', 'key' => null], ['foo', 'bar', 'baz']],
            [['subject' => ['f' => 'foo', 'b' => 'bar'], 'add' => 'baz', 'key' => 'c'], ['f' => 'foo', 'b' => 'bar', 'c' => 'baz']],
            [['subject' => ['f' => 'foo', 'b' => 'bar'], 'add' => 'baz', 'key' => 'b'], ['f' => 'foo', 'b' => 'baz']],
        ];
    }
}
