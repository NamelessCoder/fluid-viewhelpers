<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Format;

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
 * ### PregReplace regular expression ViewHeloer
 *
 * Implementation of `preg_replace` for Fluid.
 */
class PregReplaceViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'string', 'String to match with the regex pattern or patterns');
        $this->registerArgument('pattern', 'string', 'Regex pattern to match against', true);
        $this->registerArgument('replacement', 'string', 'String to replace matches with', true);
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
        $value = preg_replace($arguments['pattern'], $arguments['replacement'], $subject);
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $value,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
