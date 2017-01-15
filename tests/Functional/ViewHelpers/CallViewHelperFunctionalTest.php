<?php
namespace TYPO3\FluidViewHelpers\Tests\Functional\ViewHelpers;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Class CallViewHelperFunctionalTest
 */
class CallViewHelperFunctionalTest extends AbstractFunctionalTestCase
{
    /**
     * @return array
     */
    protected function getVariables()
    {
        return [
            'object' => $this,
            'method' => 'publicTestMethod',
            'arguments' => ['foo']
        ];
    }

    /**
     * @param mixed $input
     * @return mixed
     */
    public function publicTestMethod($input)
    {
        return $input;
    }
}
