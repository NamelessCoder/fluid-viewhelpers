<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\ArrayHelper;
use TYPO3\FluidViewHelpers\Helpers\TemplateVariableHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Creates chunks from an input Array/Traversable with option to allocate items to a fixed number of chunks
 */
class ChunkViewHelper extends AbstractViewHelper
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
        $this->registerArgument('subject', 'mixed', 'The subject Traversable/Array instance to shift');
        $this->registerArgument('count', 'integer', 'Number of items/chunk or if fixed then number of chunks', true);
        TemplateVariableHelper::getInstance()->createAsArgumentDefinition($this->argumentDefinitions);
        $this->registerArgument(
            'fixed',
            'boolean',
            'If true, creates $count chunks instead of $count values per chunk',
            false,
            false
        );
        $this->registerArgument(
            'preserveKeys',
            'boolean',
            'If set to true, the original array keys will be preserved',
            false,
            false
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return array|mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $count = (integer) $arguments['count'];
        $fixed = (boolean) $arguments['fixed'];
        $preserveKeys = (boolean) $arguments['preserveKeys'];
        $subject = ArrayHelper::getInstance()->arrayFromArrayOrTraversableOrCSV(
            isset($arguments['as']) ? $arguments['subject'] : $renderChildrenClosure(),
            $preserveKeys
        );
        $output = [];
        if (0 >= $count) {
            return $output;
        }
        if ($fixed) {
            $subjectSize = count($subject);
            if (0 < $subjectSize) {
                $chunkSize = ceil($subjectSize / $count);
                $output = array_chunk($subject, $chunkSize, $preserveKeys);
            }
            // Fill the resulting array with empty items to get the desired element count
            $elementCount = count($output);
            if ($elementCount < $count) {
                $output += array_fill($elementCount, $count - $elementCount, null);
            }
        } else {
            $output = array_chunk($subject, $count, $preserveKeys);
        }

        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $output,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }
}
