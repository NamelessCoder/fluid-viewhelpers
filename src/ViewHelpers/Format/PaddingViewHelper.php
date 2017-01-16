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
 * Formats a string using PHPs str_pad function.
 * @see http://www.php.net/manual/en/function.str_pad.php
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <f:format.padding padLength="10">TYPO3</f:format.padding>
 * </code>
 * <output>
 * TYPO3     (note the trailing whitespace)
 * <output>
 *
 * <code title="Specify padding string">
 * <f:format.padding padLength="10" padString="-=">TYPO3</f:format.padding>
 * </code>
 * <output>
 * TYPO3-=-=-
 * </output>
 *
 * <code title="Specify padding type">
 * <f:format.padding padLength="10" padString="-" padType="both">TYPO3</f:format.padding>
 * </code>
 * <output>
 * --TYPO3---
 * </output>
 */
class PaddingViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

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
        $this->registerArgument('value', 'string', 'string to format');
        $this->registerArgument('padLength', 'int', 'Length of the resulting string. If the value of pad_length is negative or less than the length of the input string, no padding takes place.', true);
        $this->registerArgument('padString', 'string', 'The padding string', false, ' ');
        $this->registerArgument('padType', 'string', 'Append the padding at this site (Possible values: right,left,both. Default: right)', false, 'right');
    }

    /**
     * Pad a string to a certain length with another string
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return string The formatted value
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $value = $renderChildrenClosure();
        $padTypes = [
            'left' => STR_PAD_LEFT,
            'right' => STR_PAD_RIGHT,
            'both' => STR_PAD_BOTH
        ];
        $padType = $arguments['padType'];
        if (!isset($padTypes[$padType])) {
            $padType = 'right';
        }

        return str_pad($value, $arguments['padLength'], $arguments['padString'], $padTypes[$padType]);
    }
}
