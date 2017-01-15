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
 * Class FilterViewHelperTest
 */
class FilterViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function nullSubjectCallsRenderChildrenToReadValue()
    {
        $subject = ['test' => 'test'];
        $arguments = [
            'preserveKeys' => true
        ];
        $result = $this->executeViewHelperUsingTagContent($arguments, [], $subject);
        $this->assertSame($subject, $result);
    }

    /**
     * @test
     */
    public function filteringEmptySubjectReturnsEmptyArrayOnInvalidSubject()
    {
        $arguments = [
            'subject' => new \DateTime('now')
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertSame($result, []);
    }

    /**
     * @test
     */
    public function supportsIterators()
    {
        $array = ['test' => 'test'];
        $iterator = new \ArrayIterator($array);
        $arguments = [
            'subject' => $iterator,
            'filter' => 'test',
            'preserveKeys' => true
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertSame($result, $array);
    }

    /**
     * @test
     */
    public function supportsPropertyName()
    {
        $array = [['test' => 'test']];
        $iterator = new \ArrayIterator($array);
        $arguments = [
            'subject' => $iterator,
            'filter' => 'test',
            'propertyName' => 'test',
            'preserveKeys' => true
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertSame($result, $array);
    }
}
