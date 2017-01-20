<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Media;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class SizeViewHelperTest
 */
class SizeViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     */
    public function returnsZeroForEmptyArguments()
    {
        $this->assertEquals(0, $this->executeViewHelperUsingTagContent([], [], '/dev/null'));
    }

    /**
     * @test
     */
    public function returnsFileSizeAsInteger()
    {
        $this->assertEquals(filesize(__FILE__), $this->executeViewHelperUsingTagContent([], [], __FILE__));
    }

    /**
     * @test
     */
    public function throwsExceptionWhenFileNotFound()
    {
        $this->expectViewHelperException();
        $this->executeViewHelperUsingTagContent([], [], '/path/does/not/exist.txt');
    }

    /**
     * @test
     */
    public function throwsExceptionWhenFileIsNotAccessibleOrIsADirectory()
    {
        $this->expectViewHelperException();
        $this->executeViewHelperUsingTagContent([], [], __DIR__);
    }
}
