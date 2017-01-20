<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Condition\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\ArrayHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * Condition ViewHelper. Renders the then-child if Iterator/array
 * haystack contains needle value.
 *
 * ### Example:
 *
 *     {f:condition.iterator.contains(needle: 'foo', haystack: {0: 'foo'}, then: 'yes', else: 'no')}
 */
class ContainsViewHelper extends AbstractConditionViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('needle', 'mixed', 'Needle to search for in haystack', true);
        $this->registerArgument('haystack', 'mixed', 'Haystack in which to look for needle', true);
        $this->registerArgument(
            'considerKeys',
            'boolean',
            'Tell whether to consider keys in the search assuming haystack is an array.',
            false,
            false
        );
    }

    /**
     * @param array $arguments
     * @return boolean
     */
    protected static function evaluateCondition($arguments = null)
    {
        $haystack = (new ArrayHelper())->arrayFromArrayOrTraversableOrCSV($arguments['haystack']);
        $needle = $arguments['needle'];
        $existsInArray = array_search($needle, $haystack) !== false;
        return $arguments['considerKeys'] ? (isset($haystack[$needle]) || $existsInArray) : $existsInArray;
    }
}
