<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Condition\Variable;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * ### Condition: Value is NULL
 *
 * Condition ViewHelper which renders the `then` child if provided
 * value is NULL.
 */
class IsNullViewHelper extends AbstractConditionViewHelper
{
    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'string', 'value to check', true);
    }

    /**
     * @param array $arguments
     * @return bool
     */
    protected static function evaluateCondition($arguments = null)
    {
        return $arguments['value'] === null;
    }
}
