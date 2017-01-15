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
 * Class NextViewHelperTest
 */
class NextViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function returnsNextElement()
    {
        $array = ['a', 'b', 'c'];
        next($array);
        $arguments = [
            'haystack' => $array,
            'needle' => 'b',
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('c', $result);
    }
}
