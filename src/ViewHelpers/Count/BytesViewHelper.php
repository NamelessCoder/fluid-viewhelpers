<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Count;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Counts bytes (multibyte-safe) in a string.
 *
 * #### Usage examples
 *
 *     <f:count.bytes>{myString}</f:count.bytes> (output for example `42`
 *
 *     {myString -> f:count.bytes()} when used inline
 *
 *     <f:count.bytes string="{myString}" />
 *
 *     {f:count.bytes(string: myString)}
 */
class BytesViewHelper extends AbstractViewHelper
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
        parent::initializeArguments();
        $this->registerArgument('string', 'string', 'String to count, if not provided as tag content');
        $this->registerArgument('encoding', 'string', 'Character set encoding of string, e.g. UTF-8 or ISO-8859-1', false, 'UTF-8');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return integer
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return mb_strlen($renderChildrenClosure(), $arguments['encoding']);
    }
}
