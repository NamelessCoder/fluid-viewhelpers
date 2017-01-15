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
 * Class DiffViewHelperTest
 */
class DiffViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @param mixed $a
     * @param mixed $b
     * @param mixed $expected
     * @test
     * @dataProvider getDiffTestValues
     */
    public function testProducesExpectedDiff($a, $b, $expected)
    {
        $result = $this->executeViewHelper(['a' => $a, 'b' => $b]);
        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function getDiffTestValues()
    {
        return [
            [['foo' ,'bar'], ['foo'], [1 => 'bar']],
            [['bar'], ['foo', 'bar'], []],
        ];
    }

}
