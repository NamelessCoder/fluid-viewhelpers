<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Count;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class SubstringViewHelperTest
 */
class SubstringViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @param array $arguments
     * @param integer $expected
     * @test
     * @dataProvider getRenderTestValues
     */
    public function testRender(array $arguments, $expected)
    {
        $this->assertEquals($expected, $this->executeViewHelper($arguments));
    }

    /**
     * @return array
     */
    public function getRenderTestValues()
    {
        return [
            [
                ['haystack' => 'foobar baz bar', 'needle' => 'bar'],
                2
            ],
            [
                ['haystack' => 'string <b>with HTML</b>', 'needle' => 'HTML'],
                1
            ],
            [
                ['haystack' => 'string with strånge unicøde chæræcters', 'needle' => 'unicøde'],
                1
            ],
        ];
    }

}
