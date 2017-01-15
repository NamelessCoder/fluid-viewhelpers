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
 * Class MergeViewHelperTest
 */
class MergeViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function testMergesArraysWithOverrule()
    {
        $array1 = ['foo'];
        $array2 = ['bar'];
        $expected = ['bar'];
        $result = $this->executeViewHelper(['a' => $array1, 'b' => $array2, 'useKeys' => false]);
        $this->assertEquals($expected, $result);
    }
}
