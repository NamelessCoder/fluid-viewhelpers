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
 * ### Condition: Value implements interface Traversable
 *
 * Condition ViewHelper which renders the `then` child if provided
 * value implements interface Traversable.
 */
class IsTraversableViewHelper extends AbstractConditionViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'mixed', 'value to check', true);
    }

    /**
     * @param array $arguments
     * @return boolean
     */
    protected static function evaluateCondition($arguments = null)
    {
        return $arguments['value'] instanceof \Traversable;
    }
}
