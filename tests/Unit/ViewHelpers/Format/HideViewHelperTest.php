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
 * Class HideViewHelperTest
 */
class HideViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function hidesTagContent()
    {
        $test = $this->executeViewHelperUsingTagContent([], [], 'this is hidden');
        $this->assertNull($test);
    }

    /**
     * @test
     */
    public function canBeDisabled()
    {
        $test = $this->executeViewHelperUsingTagContent(['disabled' => true], [], 'this is shown');
        $this->assertSame('this is shown', $test);
    }
}
