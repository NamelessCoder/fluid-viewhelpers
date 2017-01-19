<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Condition\Type;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * ### Condition: Value is an object
 *
 * Condition ViewHelper which renders the `then` child if provided
 * value is an object.
 */
class IsObjectViewHelper extends AbstractConditionViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('then', 'mixed', 'Value to be returned if the condition is met.');
        $this->registerArgument('else', 'mixed', 'Value to be returned if the condition is not met.');
        $this->registerArgument('value', 'mixed', 'value to check', true);
    }

    /**
     * @param array $arguments
     * @return boolean
     */
    protected static function evaluateCondition($arguments = null)
    {
        return is_object($arguments['value']);
    }
}
