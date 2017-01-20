<?php
namespace TYPO3\FluidViewHelpers\Tests\Functional\ViewHelpers\Format;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use \TYPO3\FluidViewHelpers\Tests\Functional\ViewHelpers\AbstractFunctionalTestCase;

/**
 * Class DateViewHelperFunctionalTest
 */
class DateViewHelperFunctionalTest extends AbstractFunctionalTestCase
{
    /**
     * @return array
     */
    protected function getVariables()
    {
        $now = new \DateTime('now');
        $fixed = new \DateTime('2017-01-16 00:00');
        $tomorrow = (new \DateTime('@' . $now->format('U')))->modify('+1 day');
        $relative = (new \DateTime('@' . $fixed->format('U')))->modify('noon');
        return [
            'date' => $fixed,
            'relativeDate' => $relative,
            'now' => $now,
            'expectedNow' => $now->format('Y-m-d'),
            'tomorrow' => $tomorrow->format('Y-m-d'),
            'strftime' => strftime('%c', $fixed->format('U'))
        ];
    }
}
