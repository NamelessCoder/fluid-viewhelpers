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
use TYPO3\FluidViewHelpers\Traits\ArrayConsumingViewHelperTrait;
use TYPO3\FluidViewHelpers\Traits\TemplateVariableViewHelperTrait;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Slice an Iterator by $start and $length.
 */
class SliceViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('haystack', 'mixed', 'The input array/Traversable to reverse');
        $this->registerArgument('start', 'integer', 'Starting offset', false, 0);
        $this->registerArgument('length', 'integer', 'Number of items to slice');
        $this->registerArgument('preserveKeys', 'boolean', 'Whether or not to preserve original keys', false, true);
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
        $haystack = ArrayHelper::getInstance()->arrayFromArrayOrTraversableOrCSV($renderChildrenClosure());
        $output = array_slice($haystack, $arguments['start'], $arguments['length'], (boolean) $arguments['preserveKeys']);
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $output,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
