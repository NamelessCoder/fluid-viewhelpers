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
 * Class ValuesViewHelperTest
 */
class ValuesViewHelperTest extends AbstractViewHelperTestCase
{
    /**
     * @test
     */
    public function returnsValuesUsingArgument()
    {
        $result = $this->executeViewHelper(['subject' => ['foo' => 'bar']]);
        $this->assertEquals(['bar'], $result);
    }

    /**
     * @test
     */
    public function supportsIterators()
    {
        $result = $this->executeViewHelper(['subject' => new \ArrayIterator(['foo' => 'bar'])]);
        $this->assertEquals(['bar'], $result);
    }
}
