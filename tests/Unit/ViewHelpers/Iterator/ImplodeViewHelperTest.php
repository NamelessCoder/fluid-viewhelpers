<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3\FluidViewHelpers\ViewHelpers\Iterator\ImplodeViewHelper;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\TemplateVariableContainer;

/**
 * Class ImplodeViewHelperTest
 */
class ImplodeViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function implodesString()
    {
        $arguments = ['content' => ['1', '2', '3'], 'glue' => ','];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('1,2,3', $result);
    }

    /**
     * @test
     */
    public function supportsCustomGlue()
    {
        $arguments = ['content' => ['1', '2', '3'], 'glue' => ';'];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('1;2;3', $result);
    }

    /**
     * @test
     */
    public function supportsConstantsGlue()
    {
        $arguments = ['content' => ['1', '2', '3'], 'glue' => 'constant:PHP_EOL'];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals("1\n2\n3", $result);
    }

    /**
     * @test
     */
    public function passesThroughUnknownSpecialGlue()
    {
        $arguments = ['content' => ['1', '2', '3'], 'glue' => 'unknown:-'];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('1-2-3', $result);
    }
}