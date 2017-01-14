<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Variable;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ### PregMatch regular expression ViewHelper
 *
 * Implementation of `preg_match' for Fluid.
 *
 * Usage:
 *
 *     <f:variable.pregMatch subject="{myString}" pattern="/[a-z]+/i" as="matches">
 *         <f:if condition="{matches -> f:count()} > 0">
 *             {matches -> f:count()} match(es) found:
 *             <f:for each="{matches}" as="match" key="index">
 *                 {index + 1}: {match}
 *             </f:for>
 *         </f:if>
 *     </f:variable.pregMatch>
 *     <!-- Alternatively, if for example you always want to iterate and don't need to check matches -->
 *     <f:for each="{f:variable.pregMatch(subject: myString, pattern: '/[a-z]+/i')}" as="match" key="index">
 *         {index + 1}: {match}
 *     </f:for>
 */
class PregMatchViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument(
            'as',
            'string',
            'Optional name of template variable to assign, which is then available in tag content'
        );
        $this->registerArgument('pattern', 'mixed', 'Regex pattern to match against', true);
        $this->registerArgument('subject', 'mixed', 'String to match with the regex pattern', true);
        $this->registerArgument('global', 'boolean', 'Match global', false, false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return array|string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        if (!isset($arguments['subject']) && empty($arguments['as'])) {
            $subject = $renderChildrenClosure();
        } else {
            $subject = $arguments['subject'];
        }
        if (true === (boolean) $arguments['global']) {
            preg_match_all($arguments['pattern'], $subject, $matches, PREG_SET_ORDER);
        } else {
            preg_match($arguments['pattern'], $subject, $matches);
        }
        if (empty($arguments['as'])) {
            return $matches;
        }
        $variableProvider = $renderingContext->getVariableProvider();
        $variableProvider->add($arguments['as'], $matches);
        $content = $renderChildrenClosure();
        $variableProvider->remove($arguments['as']);
        return $content;
    }
}
