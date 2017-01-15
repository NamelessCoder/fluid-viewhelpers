<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\TemplateVariableHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Adds one variable to the end of the array and returns the result.
 *
 * Example:
 *
 *     <f:for each="{array -> f:iterator.push(add: additionalObject, key: 'newkey')}" as="combined">
 *     ...
 *     </f:for>
 */
class PushViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'mixed', 'Input to work on - Array/Traversable/...');
        $this->registerArgument('add', 'mixed', 'Member to add to end of array', true);
        $this->registerArgument('key', 'mixed', 'Optional key to use. If key exists the member will be overwritten!');
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
        $subject = $renderChildrenClosure();
        $add = $arguments['add'];
        $key = $arguments['key'];
        if ($key) {
            $subject[$key] = $add;
        } else {
            $subject[] = $add;
        }
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $subject,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
