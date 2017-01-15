<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\ArrayHelper;
use TYPO3\FluidViewHelpers\Helpers\TemplateVariableHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ### Iterator Unique Values ViewHelper
 *
 * Implementation of `array_unique` for Fluid
 *
 * Accepts an input array of values and returns/assigns
 * a new array containing only the unique values found
 * in the input array.
 *
 * Note that the ViewHelper does not support the sorting
 * parameter - if you wish to sort the result you should
 * use `f:iterator.sort` in a chain.
 *
 * #### Usage examples
 *
 * ```xml
 * <!--
 * Given a (large) array of every user's country with possible duplicates.
 * The idea being to output only a unique list of countries' names.
 * -->
 *
 * Countries of our users: {userCountries -> f:iterator.unique() -> f:iterator.implode(glue: ' - ')}
 * ```
 *
 * Output:
 *
 * ```xml
 * Countries of our users: USA - USA - Denmark - Germany - Germany - USA - Denmark - Germany
 * ```
 *
 * ```xml
 * <!-- Given the same use case as above but also implementing sorting -->
 * Countries of our users, in alphabetical order:
 * {userCountries -> f:iterator.unique()
 *     -> f:iterator.sort(sortFlags: 'SORT_NATURAL')
 *     -> f:iterator.implode(glue: ' - ')}
 * ```
 *
 * Output:
 *
 * ```xml
 * Countries of our users: Denmark - Germany - USA
 * ```
 */
class UniqueViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'mixed', 'The input array/Traversable to process');
        TemplateVariableHelper::getInstance()->createAsArgumentDefinition($this->argumentDefinitions);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            array_unique(
                ArrayHelper::getInstance()->arrayFromArrayOrTraversableOrCSV($renderChildrenClosure())
            ),
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
