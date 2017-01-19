<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Condition\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class ContainsViewHelperTest
 */
class ContainsViewHelperTest extends AbstractViewHelperTestCase{

    /**
     * @dataProvider getPositiveTestValues
     * @param mixed $haystack
     * @param mixed $needle
     */
    public function testRendersThen($haystack, $needle)
    {
        $arguments = [
            'haystack' => $haystack,
            'needle' => $needle,
            'then' => 'then'
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('then', $result);
    }

    /**
     * @return array
     */
    public function getPositiveTestValues()
    {
        return [
            [['foo'], 'foo'],
            ['foo,bar', 'foo'],
        ];
    }

    /**
     * @dataProvider getNegativeTestValues
     * @param mixed $haystack
     * @param mixed $needle
     */
    public function testRendersElse($haystack, $needle)
    {
        $arguments = [
            'haystack' => $haystack,
            'needle' => $needle,
            'else' => 'else'
        ];
        $result = $this->executeViewHelper($arguments);
        $this->assertEquals('else', $result);
    }

    /**
     * @return array
     */
    public function getNegativeTestValues()
    {
        return [
            [['foo'], 'bar'],
            ['foo,baz', 'bar']
        ];
    }
}
