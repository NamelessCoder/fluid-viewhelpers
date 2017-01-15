<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Generate\System;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class DateTimeViewHelperTest
 */
class DateTimeViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function returnsDateTimeInstance()
    {
        $result = $this->executeViewHelper();
        $this->assertInstanceOf('DateTime', $result);
    }
}
