<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3\FluidViewHelpers\ViewHelpers\Iterator\ExplodeViewHelper;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\TemplateVariableContainer;

/**
 * Class ColumnViewHelperTest
 */
class ColumnViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @param mixed $subject
     * @param string $column
     * @param mixed $expected
     * @test
     * @dataProvider getColumnTestValues
     */
    public function testExtractsExpectedColumn($subject, $column, $expected)
    {
        $result = $this->executeViewHelper(['subject' => $subject, 'columnKey' => $column]);
        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function getColumnTestValues()
    {
        return [
            [[['a' => 'foo', 'b' => 'bar']], 'a', ['foo']],
            [[['a' => 'foo', 'b' => 'bar']], 'b', ['bar']]
        ];
    }

}
