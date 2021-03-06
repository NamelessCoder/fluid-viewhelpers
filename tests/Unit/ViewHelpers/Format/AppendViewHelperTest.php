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
 * Class AppendViewHelperTest
 */
class AppendViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function canAppendValueToArgument()
    {
        $arguments = [
            'subject' => 'before',
            'add' => 'after'
        ];
        $test = $this->executeViewHelper($arguments);
        $this->assertStringEndsWith($arguments['add'], $test);
    }

    /**
     * @test
     */
    public function canAppendValueToChildContent()
    {
        $arguments = [
            'add' => 'after'
        ];
        $test = $this->executeViewHelperUsingTagContent($arguments, [], 'before');
        $this->assertStringEndsWith($arguments['add'], $test);
    }
}
