<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * ### Unless
 *
 * The opposite of `f:if` and only supporting negative matching.
 * Related to `f:`or` but allows more complex conditions.
 *
 * Is the same as writing:
 *
 *     <f:if condition="{theThingToCheck}">
 *         <f:else>
 *             The thing that gets done
 *         </f:else>
 *     </f:if>
 *
 * Except without the `f:else`.
 *
 * #### Example, tag mode
 *
 *     <f:unless condition="{somethingRequired}">
 *         Warning! Something required was not present.
 *     </f:unless>
 *
 * #### Example, inline mode illustrating `f:`or` likeness
 *
 *     {defaultText -> f:unless(condition: originalText)}
 *         // which is much the same as...
 *     {originalText -> f:or(alternative: defaultText}
 *         // ...but the "unless" counterpart supports anything as
 *         // condition instead of only checking "is content empty?"
 */
class UnlessViewHelper extends AbstractConditionViewHelper
{
    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('condition', 'boolean', 'Condition which must not be true');
    }

    /**
     * @param array $arguments
     * @return boolean
     */
    protected static function evaluateCondition($arguments = null)
    {
        return !$arguments['condition'];
    }
}
