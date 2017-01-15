<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Generate;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTest;

/**
 * Class AsciiViewHelperTest
 */
class AsciiViewHelperTest extends AbstractViewHelperTest
{

    /**
     * @test
     * @dataProvider getTestRenderValues
     * @param integer $ascii
     * @param string $expected
     */
    public function testRender($ascii, $expected)
    {
        $result = $this->executeViewHelper(['ascii' => $ascii]);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getTestRenderValues()
    {
        return [
            [null, ''],
            [10, "\n"],
            [32, ' '],
            [64, '@'],
            [[65, 66, 67], 'ABC'],
            [new \ArrayIterator([67, 66, 65]), 'CBA']
        ];
    }
}
