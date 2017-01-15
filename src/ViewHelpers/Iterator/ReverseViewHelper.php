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
 * ### Iterator Reversal ViewHelper
 *
 * Reverses the order of every member of an Iterator/Array,
 * preserving the original keys.
 */
class ReverseViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'mixed', 'The input array/Traversable to reverse');
        TemplateVariableHelper::getInstance()->createAsArgumentDefinition($this->argumentDefinitions);
    }

    /**
     * "Render" method - sorts a target list-type target. Either $array or
     * $objectStorage must be specified. If both are, ObjectStorage takes precedence.
     *
     * Returns the same type as $subject. Ignores NULL values which would be
     * OK to use in an f:for (empty loop as result)
     *
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
        $array = ArrayHelper::getInstance()->arrayFromArrayOrTraversableOrCSV($renderChildrenClosure());
        $array = array_reverse($array, true);
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $array,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
