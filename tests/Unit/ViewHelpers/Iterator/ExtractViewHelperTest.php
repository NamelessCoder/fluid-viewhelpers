<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
use TYPO3\FluidViewHelpers\ViewHelpers\Iterator\ExtractViewHelper;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class ExtractViewHelperTest
 */
class ExtractViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @var ExtractViewHelper
     */
    protected $fixture;

    /**
     * @return array
     */
    public function simpleStructures()
    {
        $structures = [
            // structure, key, expected
            'flat associative array' => [
                ['myKey' => 'myValue'],
                'myKey',
                'myValue'
            ],
            'deeper associative array' => [
                [
                    'myFirstKey' => [
                        'mySecondKey' => [
                            'myThirdKey' => 'myValue'
                        ]
                    ]
                ],
                'myFirstKey.mySecondKey.myThirdKey',
                'myValue'
            ],
        ];

        return $structures;
    }

    /**
     * @return array
     */
    public function nestedStructures()
    {
        $structures = [
            // structure, key, expected
            'simple indexed_search searchWords array' => [
                [
                    0 => [
                        'sword' => 'firstWord',
                        'oper' => 'AND'
                    ],
                ],
                'sword',
                [
                    'firstWord'
                ]
            ],
            'interesting indexed_search searchWords array' => [
                [
                    0 => [
                        'sword' => 'firstWord',
                        'oper' => 'AND'
                    ],
                    1 => [
                        'sword' => 'secondWord',
                        'oper' => 'AND'
                    ],
                    3 => [
                        'sword' => 'thirdWord',
                        'oper' => 'AND'
                    ]
                ],
                'sword',
                [
                    'firstWord',
                    'secondWord',
                    'thirdWord'
                ]
            ],
            'ridiculously nested array' => [
                [
                    [
                        [
                            [
                                [
                                    [
                                        'l' => 'some'
                                    ]
                                ]
                            ],
                            [
                                'l' => 'text'
                            ]
                        ]
                    ]
                ],
                'l',
                [
                    0 => 'some',
                    1 => 'text',
                ]
            ],
        ];

        return $structures;
    }

    /**
     * @test
     * @dataProvider nestedStructures
     */
    public function recursivelyExtractKey($structure, $key, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->executeViewHelper(['content' => $structure, 'key' => $key, 'recursive' => true, 'single' => false])
        );
    }

    /**
     * @test
     * @dataProvider simpleStructures
     */
    public function extractByKeyExtractsKeyByPath($structure, $key, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->executeViewHelper(['content' => $structure, 'key' => $key, 'recursive' => false, 'single' => false])
        );
    }
    /**
     * @test
     * @dataProvider simpleStructures
     */
    public function extractSingleValueByKeyExtractsSingleKeyByPath($structure, $key, $expected)
    {
        $this->assertEquals(
            is_array($expected) ? reset($expected) : $expected,
            $this->executeViewHelper(['content' => $structure, 'key' => $key, 'recursive' => false, 'single' => true])
        );
    }

    /**
     * @test
     */
    public function testChangesExceptionToViewHelperException()
    {
        $errorObject = $this->getMockBuilder(\ArrayIterator::class)->setMethods(['offsetExists'])->getMock();
        $errorObject->expects($this->once())->method('offsetExists')->willThrowException(new \RuntimeException('error'));
        $this->expectViewHelperException();
        $this->executeViewHelper(['content' => ['object' => $errorObject], 'key' => 'object.0', 'recursive' => true]);
    }
}
