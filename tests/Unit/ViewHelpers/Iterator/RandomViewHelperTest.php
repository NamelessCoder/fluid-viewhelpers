<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

/**
 * Class RandomViewHelperTest
 */
class RandomViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     * @dataProvider getRenderTestValues
     * @param array $arguments
     * @param array $asArray
     */
    public function testRender(array $arguments, array $asArray)
    {
        $value = $this->executeViewHelper($arguments);
        if (null !== $value) {
            $this->assertContains($value, $asArray);
        } else {
            $this->assertNull($value);
        }
    }

    /**
     * @return array
     */
    public function getRenderTestValues()
    {
        return [
            [['subject' => []], [null]],
            [['subject' => ['foo', 'bar']], ['foo', 'bar']],
            [['subject' => new \ArrayIterator(['foo', 'bar'])], ['foo', 'bar']]
        ];
    }
}
