<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Generate\Random;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTest;

/**
 * Class StringViewHelperTest
 */
class StringViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @test
     */
    public function generatesRandomStringWithDesiredCharactersOnlyAndOfDesiredVariableLength()
    {
        $arguments = ['minimumLength' => 16, 'maximumLength' => 32, 'characters' => 'abcdef'];
        $result = $this->executeViewHelper($arguments);
        $this->assertLessThanOrEqual(32, strlen($result));
        $this->assertGreaterThanOrEqual(16, strlen($result));
        $this->assertEquals(0, preg_match('/[^a-f]+/', $result), 'Random string contained unexpected characters');
    }

    /**
     * @test
     */
    public function generatesRandomStringWithDesiredCharactersOnlyAndOfDesiredFixedLength()
    {
        $arguments = ['minimumLength' => 32, 'maximumLength' => 32, 'characters' => 'abcdef'];
        $result = $this->executeViewHelper($arguments);
        $this->assertLessThanOrEqual(32, strlen($result));
        $this->assertGreaterThanOrEqual(16, strlen($result));
        $this->assertEquals(0, preg_match('/[^a-f]+/', $result), 'Random string contained unexpected characters');
    }
}
