<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Media;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;

/**
 * Class ExtensionViewHelperTest
 */
class ExtensionViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     */
    public function returnsEmptyStringForEmptyArguments()
    {
        $this->assertEquals('', $this->executeViewHelperUsingTagContent([], [], ''));
    }

    /**
     * @test
     */
    public function returnsExpectedExtensionForProvidedPath()
    {
        $this->assertEquals('txt', $this->executeViewHelperUsingTagContent([], [], '/some/path/foo.txt'));
    }

    /**
     * @test
     */
    public function returnsEmptyStringForFileWithoutExtension()
    {
        $this->assertEquals('', $this->executeViewHelperUsingTagContent([], [], '/some/path/noext'));
    }
}
