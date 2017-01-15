<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\TemplateVariableHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Converts a string to an array with $length number of bytes
 * per new array element. Wrapper for PHP's `str_split`.
 */
class SplitViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'string', 'The string that will be split into an array');
        $this->registerArgument('length', 'integer', 'Number of bytes per chunk in the new array', false, 1);
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
        if ((integer) $arguments['length'] === 0) {
            // Difference from PHP str_split: return an empty array if (potentially dynamically defined) length
            // argument is zero for some reason. PHP would throw a warning; Fluid would logically just return empty.
            return [];
        }
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            str_split($renderChildrenClosure(), $arguments['length']),
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
