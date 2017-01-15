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
 * Class ForViewHelperTest
 */
class ForViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @param array $arguments
     * @test
     * @dataProvider getErrorTestValues
     */
    public function testErrorOnArguments(array $arguments)
    {
        $this->expectViewHelperException();
        $this->executeViewHelper($arguments);
    }

    /**
     * @return array
     */
    public function getErrorTestValues()
    {
        return [
            [['from' => 0, 'to' => 0, 'step' => 0]],
            [['from' => 10, 'to' => 0, 'step' => 1]],
            [['from' => 0, 'to' => 10, 'step' => -1]],
        ];
    }
}
