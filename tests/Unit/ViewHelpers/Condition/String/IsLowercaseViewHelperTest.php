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
 * Class IsLowercaseViewHelperTest
 */
class IsLowercaseViewHelperTest extends AbstractViewHelperTestCase{

    /**
     * @test
     */
    public function rendersThenChildIfFirstCharacterIsLowercase()
    {
        $arguments = [
            'then' => 'then',
            'else' => 'else',
            'string' => 'foobar',
            'fullString' => false
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('then', $result);
    }

    /**
     * @test
     */
    public function rendersThenChildIfAllCharactersAreLowercase()
    {
        $arguments = [
            'then' => 'then',
            'else' => 'else',
            'string' => 'foobar',
            'fullString' => true
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('then', $result);
    }

    /**
     * @test
     */
    public function rendersElseChildIfFirstCharacterIsNotLowercase()
    {
        $arguments = [
            'then' => 'then',
            'else' => 'else',
            'string' => 'FooBar',
            'fullString' => false
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('else', $result);
    }

    /**
     * @test
     */
    public function rendersElseChildIfAllCharactersAreNotLowercase()
    {
        $arguments = [
            'then' => 'then',
            'else' => 'else',
            'string' => 'fooBar',
            'fullString' => true
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('else', $result);
    }
}
