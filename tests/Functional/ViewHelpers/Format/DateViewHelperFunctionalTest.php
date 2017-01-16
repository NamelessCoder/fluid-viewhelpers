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
        return [
            'date' => new \DateTime('2017-01-16 00:00'),
            'relativeDate' => new \DateTime('noon'),
            'now' => new \DateTime('now'),
            'expectedNow' => (new \DateTime('now'))->format('Y-m-d'),
            'strftime' => strftime('%c', (new \DateTime('2017-01-16 00:00'))->format('U'))
        ];
    }
}
