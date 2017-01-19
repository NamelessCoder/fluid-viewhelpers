<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Condition\Type;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class IsArrayViewHelperTest
 */
class IsArrayViewHelperTest extends AbstractViewHelperTestCase{

    /**
     * @test
     */
    public function rendersThenChildIfConditionMatched()
    {
        $arguments = [
            'then' => 'then',
            'else' => 'else',
            'value' => []
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
            'value' => new \stdClass()
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('else', $result);
    }
}
