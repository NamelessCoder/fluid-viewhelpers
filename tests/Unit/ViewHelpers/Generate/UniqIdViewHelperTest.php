<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Generate;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class UniqIdViewHelperTest
 */
class UniqIdViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function returnsUniqueIds()
    {
        $arguments = ['prefix' => '', 'moreEntropy' => false];
        $result1 = $this->executeViewHelper($arguments);
        $result2 = $this->executeViewHelper($arguments);
        $this->assertNotEquals($result1, $result2);
    }
}
