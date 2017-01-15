<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Variable;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ### Convert ViewHelper
 *
 * Converts $value to $type which can be one of 'string', 'integer',
 * 'float', 'boolean', 'array' or 'ObjectStorage'. If $value is NULL
 * sensible defaults are assigned or $default which obviously has to
 * be of $type as well.
 *
 * Useful on installations where the CastingExpressionNode is not available.
 */
class ConvertViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('value', 'mixed', 'Value to convert into a different type');
        $this->registerArgument(
            'type',
            'string',
            'Data type to convert the value into. Can be one of "string", "integer", "float", "boolean", "array" ' .
            'or "ObjectStorage".',
            true
        );
        $this->registerArgument(
            'default',
            'mixed',
            'Optional default value to assign to the converted variable in case it is NULL.',
            false,
            null
        );
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
        $value = $renderChildrenClosure();
        $type = $arguments['type'];
        if (gettype($value) === $type) {
            return $value;
        }
        if (null !== $value) {
            if ('array' === $type && true === $value instanceof \Traversable) {
                $value = iterator_to_array($value, false);
            } elseif ('array' === $type) {
                $value = [$value];
            } else {
                settype($value, $type);
            }
        } else {
            if (true === isset($arguments['default'])) {
                $value = $arguments['default'];
            } else {
                switch ($type) {
                    case 'string':
                        $value = '';
                        break;
                    case 'int':
                    case 'integer':
                        $value = 0;
                        break;
                    case 'bool':
                    case 'boolean':
                        $value = false;
                        break;
                    case 'double':
                    case 'float':
                        $value = 0.0;
                        break;
                    case 'array':
                        $value = [];
                        break;
                    default:
                        throw new Exception(
                            sprintf('Provided argument "type" (value: "%s") is not supported', $type),
                            1364542884
                        );
                }
            }
        }
        return $value;
    }
}
