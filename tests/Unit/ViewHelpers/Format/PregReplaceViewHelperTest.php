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
 * Class PregReplaceViewHelperTest
 */
class PregReplaceViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function canReplaceValues()
    {
        $arguments = [
            'subject' => 'foo123bar',
            'pattern' => '/[0-9]{3}/',
            'replacement' => 'baz',
        ];
        $test = $this->executeViewHelper($arguments);
        $this->assertSame('foobazbar', $test);
    }
}
