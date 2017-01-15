<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\NodeInterface;

/**
 * Class LoopViewHelperTest
 */
class LoopViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @param array $arguments
     * @param mixed $expected
     * @param NodeInterface|string $node
     * @test
     * @dataProvider getLoopTestValues
     */
    public function testPerformsExpectedLoop(array $arguments, $node, $expected)
    {
        $result = $this->executeViewHelperUsingTagContent($arguments, [], $node);
        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function getLoopTestValues()
    {
        return [
            [['count' => 5], 'a', 'aaaaa'],
            [['count' => 10], 'b', 'bbbbbbbbbb'],
            [['count' => 10, 'maximum' => 5], 'c', 'ccccc'],
        ];
    }
}
