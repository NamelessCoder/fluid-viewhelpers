<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Condition\String;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * ### Condition: String is lowercase
 *
 * Condition ViewHelper which renders the `then` child if provided
 * string is uppercase. By default only the first letter is tested.
 * To test the full string set $fullString to TRUE.
 */
class IsUppercaseViewHelper extends AbstractConditionViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('string', 'string', 'string to check', true);
        $this->registerArgument('fullString', 'string', 'need', false, false);
    }

    /**
     * @param array $arguments
     * @return bool
     */
    protected static function evaluateCondition($arguments = null)
    {
        return ctype_upper($arguments['fullString'] ? $arguments['string'] : $arguments['string']{0});
    }
}
