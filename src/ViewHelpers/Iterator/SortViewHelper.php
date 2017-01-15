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
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\Variables\StandardVariableProvider;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Sorts an instance of ObjectStorage, an Iterator implementation,
 * an Array or a QueryResult (including Lazy counterparts).
 *
 * Can be used inline, i.e.:
 *
 *
 *     <f:for each="{dataset -> vhs:iterator.sort(sortBy: 'name')}" as="item">
 *         // iterating data which is ONLY sorted while rendering this particular loop
 *     </f:for>
 */
class SortViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * Contains all flags that are allowed to be used
     * with the sorting functions
     *
     * @var array
     */
    protected static $allowedSortFlags = [
        'SORT_REGULAR',
        'SORT_STRING',
        'SORT_NUMERIC',
        'SORT_NATURAL',
        'SORT_LOCALE_STRING',
        'SORT_FLAG_CASE'
    ];

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('subject', 'mixed', 'The array/Traversable instance to sort');
        $this->registerArgument(
            'sortBy',
            'string',
            'Which property/field to sort by - leave out for numeric sorting based on indexes(keys)'
        );
        $this->registerArgument(
            'order',
            'string',
            'ASC, DESC or RAND. RAND preserves keys',
            false,
            'ASC'
        );
        $this->registerArgument(
            'sortFlags',
            'string',
            'Constant name from PHP for `SORT_FLAGS`: `SORT_REGULAR`, `SORT_STRING`, `SORT_NUMERIC`, ' .
            '`SORT_NATURAL`, `SORT_LOCALE_STRING` or `SORT_FLAG_CASE`. You can provide a comma separated list or ' .
            'an array to use a combination of flags.',
            false,
            static::$allowedSortFlags[0]
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
        $subject = ArrayHelper::getInstance()->arrayFromArrayOrTraversableOrCSV($renderChildrenClosure());
        if (null !== $subject && !is_array($subject)) {
            // a NULL value is respected and ignored, but any
            // unrecognized value other than this is considered a
            // fatal error.
            throw new Exception(
                'Unsortable variable type passed to Iterator/SortViewHelper. Expected any of Array, QueryResult, ' .
                ' ObjectStorage or Iterator implementation but got ' . gettype($subject),
                1351958941
            );
        }

        $flags = static::getSortFlags($arguments);
        $order = $arguments['order'];
        $property = $arguments['sortBy'];
        if ($order === 'RAND') {
            shuffle($subject);
        } else {
            usort($subject, function($a, $b) use ($flags, $order, $property) {
                if ($property) {
                    $a = static::getSortValue($a, $property);
                    $b = static::getSortValue($b, $property);
                }
                $before = [$a, $b];
                $after = $before;
                sort($after, $flags);
                if ($before === $after) {
                    return 0;
                }
                return (
                    array_search($a, $after) < array_search($a, $before)
                        ? ($order === 'ASC' ? -1 : 1)
                        : ($order === 'ASC' ? 1 : -1)
                );
            });
        }

        return TemplateVariableHelper::getInstance()->renderChildrenWithVariableOrReturnInput(
            $subject,
            $arguments['as'],
            $renderingContext,
            $renderChildrenClosure
        );
    }

    /**
     * Gets the value to use as sorting value from $object
     *
     * @param mixed $object
     * @return mixed
     */
    protected static function getSortValue($object, $property)
    {
        $extractor = new StandardVariableProvider(['object' => $object]);
        $value = $extractor->getByPath('object.' . $property);

        if (true === $value instanceof \DateTime) {
            $value = intval($value->format('U'));
        } elseif (is_array($value)) {
            $value = count($value);
        }
        return $value;
    }

    /**
     * Parses the supplied flags into the proper value for the sorting
     * function.
     *
     * @param array $arguments
     * @return int
     */
    protected static function getSortFlags(array $arguments)
    {
        $constants = ArrayHelper::getInstance()->arrayFromArrayOrTraversableOrCSV($arguments['sortFlags']);
        $flags = 0;
        foreach ($constants as $constant) {
            if (false === in_array($constant, static::$allowedSortFlags)) {
                throw new Exception(
                    'The constant "' . $constant . '" you\'re trying to use as a sortFlag is not allowed. Allowed ' .
                    'constants are: ' . implode(', ', static::$allowedSortFlags) . '.',
                    1404220538
                );
            }
            $flags = $flags | constant(trim($constant));
        }
        return $flags;
    }
}
