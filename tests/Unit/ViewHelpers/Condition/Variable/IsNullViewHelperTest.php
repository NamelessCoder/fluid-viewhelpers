<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Condition\Variable;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class IsNullViewHelperTest
 */
class IsNullViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     */
    public function rendersThenChildIfVariableIsNull()
    {
        $arguments = [
            'value' => null,
            'then' => 'then',
            'else' => 'else'
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals($arguments['then'], $result);
    }

    /**
     * @test
     */
    public function rendersElseChildIfVariableIsNotNull()
    {
        $arguments = [
            'value' => true,
            'then' => 'then',
            'else' => 'else'
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals($arguments['else'], $result);
    }
}
