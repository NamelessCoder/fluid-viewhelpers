<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Condition\Variable;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
use TYPO3\FluidViewHelpers\Traits\ConditionViewHelperTrait;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ### Variable: Isset
 *
 * Renders the `then` child if the variable name given in
 * the `name` argument exists in the template. The value
 * can be zero, NULL or an empty string - but the ViewHelper
 * will still return TRUE if the variable exists.
 *
 * Combines well with dynamic variable names:
 *
 *     <!-- if {variableContainingVariableName} is "foo" this checks existence of {foo} -->
 *     <f:condition.variable.isset name="{variableContainingVariableName}">...</v:condition.variable.isset>
 *     <!-- if {suffix} is "Name" this checks existence of "variableName" -->
 *     <f:condition.variable.isset name="variable{suffix}">...</v:condition.variable.isset>
 *     <!-- outputs value of {foo} if {bar} is defined -->
 *     {foo -> f:condition.variable.isset(name: bar)}
 */
class IssetViewHelper extends AbstractConditionViewHelper
{
    /**
     * @var RenderingContextInterface
     */
    protected static $activeRenderingContext;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('then', 'mixed', 'Value to be returned if the condition is met.');
        $this->registerArgument('else', 'mixed', 'Value to be returned if the condition is not met.');
        $this->registerArgument('name', 'string', 'name of the variable', true);
    }

    /**
     * @param array|null $arguments
     * @return boolean
     */
    protected static function evaluateCondition($arguments = null)
    {
        return static::$activeRenderingContext->getVariableProvider()->exists($arguments['name']);
    }

    /**
     * Default implementation for use in compiled templates
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        static::$activeRenderingContext = $renderingContext;
        return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
    }
}
