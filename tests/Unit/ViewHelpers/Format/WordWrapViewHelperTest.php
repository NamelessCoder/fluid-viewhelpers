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
 * Class WordWrapViewHelperTest
 */
class WordWrapViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function willWrapStringAccordingToArguments()
    {
        $content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, et id ipsum modi molestiae molestias numquam! Aperiam assumenda commodi ducimus harum iure nostrum odit, vel voluptatem! Beatae commodi qui rem!';
        $arguments = [
            'limit' => 25,
            'break' => PHP_EOL,
            'glue' => '|',
        ];
        $test = $this->executeViewHelperUsingTagContent($arguments, [], $content);
        $this->assertRegExp('/.{0,25}\|/', $test);
    }
}
