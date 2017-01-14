<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * ### Call ViewHelper
 *
 * Calls a method on an existing object. Usable as inline or tag.
 *
 * ### Examples
 *
 *     <!-- inline, useful as argument, for example in f:for -->
 *     {object -> f:call(method: 'toArray')}
 *     <!-- tag, useful to quickly output simple values -->
 *     <f:call object="{object}" method="unconventionalGetter" />
 *     <f:call method="unconventionalGetter">{object}</f:call>
 *     <!-- arguments for the method -->
 *     <f:call object="{object}" method="doSomethingWithArguments" arguments="{0: 'foo', 1: 'bar'}" />
 */
class CallViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('object', 'object', 'Instance to call method on');
        $this->registerArgument('method', 'string', 'Name of method to call on instance', true);
        $this->registerArgument('arguments', 'array', 'Array of arguments if method requires arguments', false, []);
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
        $object = $renderChildrenClosure();
        $method = $arguments['method'];
        $methodArguments = $arguments['arguments'];
        if (false === is_object($object)) {
            throw new Exception(
                'Using v:call requires an object either as "object" attribute, tag content or inline argument',
                1356849652
            );
        }
        if (false === method_exists($object, $method)) {
            throw new Exception(
                'Method "' . $method . '" does not exist on object of type ' . get_class($object),
                1356834755
            );
        }
        return call_user_func_array([$object, $method], $methodArguments);
    }
}