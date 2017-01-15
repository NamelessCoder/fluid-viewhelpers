<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\TemplateVariableHelper;
use TYPO3\FluidViewHelpers\Traits\BasicViewHelperTrait;
use TYPO3\FluidViewHelpers\Traits\TemplateVariableViewHelperTrait;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Explode ViewHelper
 *
 * Explodes a string by $glue.
 */
class ExplodeViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var string
     */
    protected static $method = 'explode';

    /**
     * Initialize
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('content', 'string', 'String to be exploded by glue');
        $this->registerArgument(
            'glue',
            'string',
            'String used as glue in the string to be exploded. Use glue value of "constant:NAMEOFCONSTANT" ' .
            '(fx "constant:PHP_EOL" for linefeed as glue)',
            false,
            ','
        );
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
        $content = isset($arguments['as']) ? $arguments['content'] : $renderChildrenClosure();
        $glue = static::resolveGlue($arguments);
        $output = call_user_func_array(static::$method, [$glue, $content]);
        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $output,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }

    /**
     * Detects the proper glue string to use for implode/explode operation
     *
     * @param array $arguments
     * @return string
     */
    protected static function resolveGlue(array $arguments)
    {
        $glue = $arguments['glue'];
        if (false !== strpos($glue, ':') && 1 < strlen($glue)) {
            // glue contains a special type identifier, resolve the actual glue
            list ($type, $value) = explode(':', $glue);
            switch ($type) {
                case 'constant':
                    $glue = constant($value);
                    break;
                default:
                    $glue = $value;
            }
        }
        return $glue;
    }
}
