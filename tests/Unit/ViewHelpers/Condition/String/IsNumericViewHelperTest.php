<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Condition\String;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class IsNumericViewHelperTest
 */
class IsNumericViewHelperTest extends AbstractViewHelperTestCase{

    /**
     * @test
     */
    public function rendersThenChildIfConditionMatched()
    {
        $arguments = [
            'then' => 'then',
            'else' => 'else',
            'value' => '123'
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('then', $result);
    }

    /**
     * @test
     */
    public function rendersElseChildIfConditionNotMatched()
    {
        $arguments = [
            'then' => 'then',
            'else' => 'else',
            'value' => 'z123'
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('else', $result);
    }
}
