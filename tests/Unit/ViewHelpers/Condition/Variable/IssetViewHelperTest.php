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
 * Class IssetViewHelperTest
 */
class IssetViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     */
    public function rendersThenChildIfVariableIsSet()
    {
        $arguments = [
            'name' => 'test',
            'then' => 'then',
            'else' => 'else'
        ];
        $variables = [
            'test' => true
        ];
        $result = $this->executeViewHelper($arguments, $variables);
        $this->assertEquals($arguments['then'], $result);
    }

    /**
     * @test
     */
    public function rendersElseChildIfVariableIsNotSet()
    {
        $arguments = [
            'name' => 'test',
            'then' => 'then',
            'else' => 'else'
        ];
        $variables = [];
        $result = $this->executeViewHelper($arguments, $variables);
        $this->assertEquals($arguments['else'], $result);
    }
}
