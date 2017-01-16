<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Format;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Applies html_entity_decode() to a value
 * @see http://www.php.net/html_entity_decode
 *
 * = Examples =
 *
 * <code title="default notation">
 * <f:format.htmlentitiesDecode>{text}</f:format.htmlentitiesDecode>
 * </code>
 * <output>
 * Text with &amp; &quot; &lt; &gt; replaced by unescaped entities (html_entity_decode applied).
 * </output>
 *
 * <code title="inline notation">
 * {text -> f:format.htmlentitiesDecode(encoding: 'ISO-8859-1')}
 * </code>
 * <output>
 * Text with &amp; &quot; &lt; &gt; replaced by unescaped entities (html_entity_decode applied).
 * </output>
 *
 * @api
 */
class HtmlentitiesDecodeViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * We accept value and children interchangeably, thus we must disable children escaping.
     *
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * If we decode, we must not encode again after that.
     *
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Initialize ViewHelper arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'string', 'string to format');
        $this->registerArgument('keepQuotes', 'bool', 'If TRUE, single and double quotes won\'t be replaced (sets ENT_NOQUOTES flag).', false, false);
        $this->registerArgument('encoding', 'string', '');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $encoding = $arguments['encoding'];
        $keepQuotes = $arguments['keepQuotes'];
        $flags = $keepQuotes ? ENT_NOQUOTES : ENT_COMPAT;
        return html_entity_decode((string) $renderChildrenClosure(), $flags, $encoding);
    }
}
