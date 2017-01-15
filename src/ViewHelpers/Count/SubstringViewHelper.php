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
 * Counts number of lines in a string.
 *
 * #### Usage examples
 *
 *     <f:count.substring string="{myString}">{haystack}</f:count.substring> (output for example `2`
 *
 *     {haystack -> f:count.substring(string: myString)} when used inline
 *
 *     <f:count.substring string="{myString}" haystack="{haystack}" />
 *
 *     {f:count.substring(string: myString, haystack: haystack)}
 */
class SubstringViewHelper extends AbstractViewHelper
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
        $this->registerArgument('haystack', 'string', 'String to count substring in, if not provided as tag content');
        $this->registerArgument('string', 'string', 'Substring to count occurrences of', true);
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
        return mb_substr_count(
            $renderChildrenClosure(), $arguments['string']
        );
    }
}
