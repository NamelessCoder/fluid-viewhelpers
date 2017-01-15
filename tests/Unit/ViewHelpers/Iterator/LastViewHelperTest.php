<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class LastViewHelperTest
 */
class LastViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function returnsLastElement()
    {
        $array = ['a', 'b', 'c'];
        $arguments = [
            'haystack' => $array
        ];
        $output = $this->executeViewHelper($arguments);
        $this->assertEquals('c', $output);
    }

    /**
     * @test
     */
    public function supportsIterators()
    {
        $array = new \ArrayIterator(['a', 'b', 'c']);
        $arguments = [
            'haystack' => $array
        ];
        $output = $this->executeViewHelper($arguments);
        $this->assertEquals('c', $output);
    }

    /**
     * @test
     */
    public function supportsTagContent()
    {
        $array = ['a', 'b', 'c'];
        $arguments = [
            'haystack' => null
        ];
        $output = $this->executeViewHelperUsingTagContent($arguments, [], $array);
        $this->assertEquals('c', $output);
    }

    /**
     * @test
     */
    public function returnsNullIfHaystackIsEmptyArray()
    {
        $arguments = [
            'haystack' => []
        ];
        $output = $this->executeViewHelper($arguments);
        $this->assertEquals(null, $output);
    }
}
