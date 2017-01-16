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
 * Class TrimViewHelperTest
 */
class TrimViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function canTrimSpecificCharacters()
    {
        $arguments = [
            'content' => 'ztrimmedy',
            'characters' => 'zy'
        ];
        $test = $this->executeViewHelper($arguments);
        $this->assertSame('trimmed', $test);
    }

    /**
     * @test
     */
    public function canTrim()
    {
        $arguments = [
            'content' => ' trimmed '
        ];
        $test = $this->executeViewHelper($arguments);
        $this->assertSame('trimmed', $test);
    }
}
