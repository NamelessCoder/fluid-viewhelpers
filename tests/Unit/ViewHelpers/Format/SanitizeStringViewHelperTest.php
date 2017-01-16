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
 * Class SanitizeStringViewHelperTest
 */
class SanitizeStringViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     * @dataProvider getInputsAndExpectedOutputs
     * @param string $input
     * @param string $expectedOutput
     */
    public function sanitizesString($input, $expectedOutput)
    {
        $result = $this->executeViewHelper(['string' => $input]);
        $this->assertEquals($expectedOutput, $result);
    }

    /**
     * @return array
     */
    public function getInputsAndExpectedOutputs()
    {
        return [
            ['this string needs dashes', 'this-string-needs-dashes'],
            ['THIS SHOULD BE LOWERCASE', 'this-should-be-lowercase'],
            ['THESE øæå chars are not allowed', 'these-oeaeaa-chars-are-not-allowed'],
            ['many           spaces become one dash', 'many-spaces-become-one-dash']
        ];
    }
}
