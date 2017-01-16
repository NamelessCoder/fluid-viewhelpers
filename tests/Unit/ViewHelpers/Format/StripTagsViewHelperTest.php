<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Format;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class StripTagsViewHelperTest
 */
class StripTagsViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     * @dataProvider getInputsAndExpectedOutputs
     * @param string $input
     * @param string $expectedOutput
     */
    public function stripsTags($input, $expectedOutput)
    {
        $result = $this->executeViewHelper(['value' => $input, 'allowedTags' => '<i>']);
        $this->assertSame($expectedOutput, $result);
    }

    /**
     * @return array
     */
    public function getInputsAndExpectedOutputs()
    {
        return [
            ['<b>value</b>', 'value'],
            ['<i>value</i>', '<i>value</i>'],
            ['', ''],
            [null, null]
        ];
    }
}
