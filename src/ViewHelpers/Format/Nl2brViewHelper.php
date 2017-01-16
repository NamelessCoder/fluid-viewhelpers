<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Format;

/*
 * This file belongs to the package "TYPO3/FluidViewHelpers".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Wrapper for PHPs nl2br function.
 * @see http://www.php.net/manual/en/function.nl2br.php
 *
 * = Examples =
 *
 * <code title="Example">
 * <f:format.nl2br>{text_with_linebreaks}</f:format.nl2br>
 * </code>
 * <output>
 * text with line breaks replaced by <br />
 * </output>
 *
 * <code title="Inline notation">
 * {text_with_linebreaks -> f:format.nl2br()}
 * </code>
 * <output>
 * text with line breaks replaced by <br />
 * </output>
 */
class Nl2brViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'string', 'string to format');
    }

    /**
     * Applies nl2br() on the specified value.
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        return nl2br($renderChildrenClosure());
    }
}
