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
 * Class IndexOfViewHelperTest
 */
class IndexOfViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function returnsIndexOfElement()
    {
        $array = ['a', 'b', 'c'];
        $arguments = [
            'haystack' => $array,
            'needle' => 'c',
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals(2, $result);
    }

    /**
     * @test
     */
    public function returnsNegativeOneIfNeedleDoesNotExist()
    {
        $array = ['a', 'b', 'c'];
        $arguments = [
            'haystack' => $array,
            'needle' => 'd',
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals(-1, $result);
    }
}
