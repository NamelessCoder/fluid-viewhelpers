<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\TemplateVariableHelper;
use TYPO3\FluidViewHelpers\Traits\ArrayConsumingViewHelperTrait;
use TYPO3\FluidViewHelpers\Traits\TemplateVariableViewHelperTrait;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ### Iterator Column Extraction ViewHelper
 *
 * Implementation of `array_column` for Fluid.
 *
 * Accepts an input iterator/array and creates a new array
 * using values from one column and optionally keys from another
 * column.
 *
 * #### Usage examples
 *
 * ```xml
 * <!-- Given input array of user data arrays with "name" and "uid" column: -->
 * <f:for each="{users -> f:iterator.column(columnKey: 'name', indexKey: 'uid')}" as="username" key="uid">
 *     User {username} has UID {uid}.
 * </f:for>
 * ```
 *
 * The above demonstrates the logic of the ViewHelper, but the
 * example itself of course gives the same result as just iterating
 * the `users` variable itself and outputting `{user.username}` etc.,
 * but the real power of the ViewHelper comes when using it to feed
 * other ViewHelpers with data sets:
 *
 * ```xml
 * <!--
 * Given same input array as above. Idea being that *any* iterator
 * can be supported as input for "options".
 * -->
 * Select user: <f:form.select options="{users -> f:iterator.column(columnKey: 'name', indexKey: 'uid')}" />
 * ```
 *
 * ```xml
 * <!-- Given same input array as above. Idea being to output all user UIDs as CSV -->
 * All UIDs: {users -> f:iterator.column(columnKey: 'uid') -> f:iterator.implode()}
 * ```
 *
 * ```xml
 * <!-- Given same input array as above. Idea being to output all unique users' countries as a list: -->
 * Our users live in the following countries:
 * {users -> f:iterator.column(columnKey: 'countryName')
 *     -> f:iterator.unique()
 *     -> f:iterator.implode(glue: ' - ')}
 * ```
 *
 * Note that the ViewHelper also supports the "as" argument which
 * allows you to not return the new array but instead assign it
 * as a new template variable - like any other "as"-capable ViewHelper.
 *
 * #### Caveat
 *
 * This ViewHelper passes the subject directly to `array_column` and
 * as such it *does not support dotted paths in either key argument
 * to extract sub-properties*. That means it *does not support Extbase
 * enties as input unless you explicitly implemented `ArrayAccess` on
 * the model of the entity and even then support is limited to first
 * level properties' values without dots in their names*.
 */
class ColumnViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'mixed', 'Input to work on - Array/Traversable/...');
        $this->registerArgument(
            'columnKey',
            'string',
            'Name of the column whose values will become the value of the new array'
        );
        $this->registerArgument(
            'indexKey',
            'string',
            'Name of the column whose values will become the index of the new array'
        );
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
        $output = array_column(
            isset($arguments['as']) ? $arguments['subject'] : $renderChildrenClosure(),
            $arguments['columnKey'], $arguments['indexKey']
        );
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $output,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
