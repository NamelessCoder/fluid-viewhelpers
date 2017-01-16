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
 * Class PlaintextViewHelperTest
 */
class PlaintextViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function formatsToPlaintext()
    {
        $input = "	This string\n	is plain-text formatted";
        $expected = "This string\nis plain-text formatted";
        $result = $this->executeViewHelper(['content' => $input]);
        $this->assertEquals($expected, $result);
    }
}
