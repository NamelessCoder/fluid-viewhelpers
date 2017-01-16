<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Format;

/*
 * This file belongs to the package "TYPO3/FluidViewHelpers".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Formats a number with custom precision, decimal point and grouped thousands.
 *
 * @see http://www.php.net/manual/en/function.number-format.php
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <f:format.number>423423.234</f:format.number>
 * </code>
 * <output>
 * 423,423.20
 * </output>
 *
 * <code title="With all parameters">
 * <f:format.number decimals="1" decimalSeparator="," thousandsSeparator=".">423423.234</f:format.number>
 * </code>
 * <output>
 * 423.423,2
 * </output>
 */
class NumberViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Output is escaped already. We must not escape children, to avoid double encoding.
     *
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('decimals', 'int', 'The number of digits after the decimal point', false, '2');
        $this->registerArgument('decimalSeparator', 'string', 'The decimal point character', false, '.');
        $this->registerArgument('thousandsSeparator', 'string', 'The character for grouping the thousand digits', false, ',');
    }

    /**
     * Format the numeric value as a number with grouped thousands, decimal point and
     * precision.
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string The formatted number
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $decimals = $arguments['decimals'];
        $decimalSeparator = $arguments['decimalSeparator'];
        $thousandsSeparator = $arguments['thousandsSeparator'];

        $stringToFormat = $renderChildrenClosure();
        return number_format($stringToFormat, $decimals, $decimalSeparator, $thousandsSeparator);
    }
}
