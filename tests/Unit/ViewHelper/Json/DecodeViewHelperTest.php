<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Json;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTest;

/**
 * Class DecodeViewHelperTest
 */
class DecodeViewHelperTest extends AbstractViewHelperTest
{

    /**
     * @test
     */
    public function returnsNullForEmptyArguments()
    {
        $instance = $this->buildViewHelperInstance();
        $result = $instance::renderStatic([], function () {}, $this->getRenderingContext($instance));
        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function returnsExpectedValueForProvidedArguments()
    {

        $fixture = '{"foo":"bar","bar":true,"baz":1,"foobar":null}';

        $expected = [
            'foo' => 'bar',
            'bar' => true,
            'baz' => 1,
            'foobar' => null,
        ];

        $result = $this->executeViewHelper(['json' => $fixture]);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function throwsExceptionForInvalidArgument()
    {
        $invalidJson = "{'foo': 'bar'}";
        $this->expectViewHelperException();
        $this->executeViewHelper(['json' => $invalidJson]);
    }
}
