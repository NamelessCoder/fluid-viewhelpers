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
 * Class SortViewHelperTest
 */
class SortViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @param array $arguments
     * @param array $expected
     * @test
     * @dataProvider getSortTestValues
     */
    public function testSortsCorrectly(array $arguments, array $expected)
    {

    }

    /**
     * @return array
     */
    public function getSortTestValues()
    {
        return [
            ['subject' => ['a', 'c', 'b'], ['a', 'b', 'c']]
        ];
    }

    /**
     * @test
     */
    public function throwsExceptionOnUnsupportedSortFlag()
    {
        $arguments = ['sortFlags' => 'FOOBAR'];
        $this->expectViewHelperException('The constant "FOOBAR" you\'re trying to use as a sortFlag is not allowed.');
        $this->executeViewHelperUsingTagContent($arguments, [], ['a', 'b', 'c']);
    }
}
