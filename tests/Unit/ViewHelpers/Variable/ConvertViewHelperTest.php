<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Variable;

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTest;

/**
 * Class ConvertViewHelperTest
 */
class ConvertViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @param mixed $input
     * @param string $type
     * @param mixed $default
     * @param mixed $expectedErrorMessage
     * @param mixed $expectedErrorCode
     * @test
     * @dataProvider getErrorTestValues
     */
    public function testThrowsErrorsAsExpected($input, $type, $default, $expectedErrorMessage, $expectedErrorCode)
    {
        $arguments = ['value' => $input, 'type' => $type, 'default' => $default];
        $this->expectViewHelperException($expectedErrorMessage, $expectedErrorCode);
        $this->executeViewHelper($arguments);
    }

    /**
     * @return array
     */
    public function getErrorTestValues()
    {
        return [
            [null, 'invalid', null, 'Provided argument "type" (value: "invalid") is not supported', 1364542884],
        ];
    }

    /**
     * @param mixed $input
     * @param string $type
     * @param mixed $default
     * @param mixed $expected
     * @test
     * @dataProvider getConvertTestValues
     */
    public function testConvertsVariable($input, $type, $default, $expected)
    {
        $arguments = ['value' => $input, 'type' => $type, 'default' => $default];
        $result = $this->executeViewHelper($arguments);
        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function getConvertTestValues()
    {
        return [
            [0, 'integer', null, 0],
            [0, 'bool', null, false],
            [1, 'bool', null, true],
            [1, 'boolean', null, true],
            [0, 'boolean', null, false],
            [2, 'double', null, 2.0],
            [2, 'float', null, 2.0],
            [null, 'double', null, 0.0],
            [null, 'int', null, 0],
            [null, 'integer', null, 0],
            [null, 'float', null, 0.0],
            [null, 'string', null, ''],
            [null, 'bool', null, false],
            [null, 'boolean', null, false],
            ['0', 'integer', null, 0],
            [null, 'array', null, []],
            ['foobar', 'array', null, ['foobar']],
            [new \ArrayIterator(['foobar']), 'array', null, ['foobar']],
            [null, 'array', ['foobar'], ['foobar']],
        ];
    }
}
