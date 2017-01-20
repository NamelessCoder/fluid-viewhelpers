<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\TemplateVariableHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ### Iterator / Extract VieWHelper
 *
 * Loop through the iterator and extract a key, optionally join the
 * results if more than one value is found.
 *
 * #### Extract values from an array by key
 *
 * The extbase version of indexed_search returns an array of the
 * previous search, which cannot easily be shown in the input field
 * of the result page. This can be solved.
 *
 * #### Input from extbase version of indexed_search">
 *
 *     [
 *         0 => [
 *             'sword' => 'firstWord',
 *             'oper' => 'AND'
 *         ],
 *         1 => [
 *             'sword' => 'secondWord',
 *             'oper' => 'AND'
 *         ],
 *         3 => [
 *             'sword' => 'thirdWord',
 *             'oper' => 'AND'
 *         ]
 *     ]
 *
 * Show the previous search words in the search form of the
 * result page:
 *
 * #### Example
 *     <f:form.textfield name="search[sword]"
 *         value="{f:iterator.extract(key:'sword', content: searchWords) -> f:iterator.implode(glue: ' ')}"
 *         class="tx-indexedsearch-searchbox-sword" />
 *
 * #### Get the names of several users
 *
 * Provided we have a bunch of FrontendUsers and we need to show
 * their firstname combined into a string:
 *
 *     <h2>Welcome
 *     <f:iterator.implode glue=", "><f:iterator.extract key="firstname" content="frontendUsers" /></v:iterator.implode>
 *     <!-- alternative: -->
 *     {frontendUsers -> f:iterator.extract(key: 'firstname') -> f:iterator.implode(glue: ', ')}
 *     </h2>
 *
 * #### Output
 *
 *     <h2>Welcome Peter, Paul, Marry</h2>
 *
 * #### Complex example
 *
 *     {anArray->v:iterator.extract(path: 'childProperty.secondNestedChildObject')
 *         -> f:iterator.sort(direction: 'DESC', sortBy: 'propertyOnSecondChild')
 *         -> f:iterator.slice(length: 10)->v:iterator.extract(key: 'uid')}
 *
 * #### Single return value
 *
 *     Outputs the "uid" value of the first record in variable $someRecords without caring if there are more than
 *     one records. Always extracts the first value and then stops. Equivalent of chaning -> f:iterator.first().
 *     {someRecords -> f:iterator.extract(key: 'uid', single: TRUE)}
 */
class ExtractViewHelper extends AbstractViewHelper
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
        $this->registerArgument('content', 'mixed', 'The array or Iterator that contains either the value or arrays of values');
        $this->registerArgument('key', 'string', 'The name of the key from which you wish to extract the value', true);
        $this->registerArgument('recursive', 'boolean', 'If TRUE, attempts to extract the key from deep nested arrays', false, true);
        $this->registerArgument('single', 'boolean', 'If TRUE, returns only one value - always the first one - instead of an array of values', false, false);
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
        $content = $renderChildrenClosure();
        $key = $arguments['key'];
        $recursive = (boolean) $arguments['recursive'];
        $single = (boolean) $arguments['single'];
        try {
            // extraction from Iterators could potentially use a getter method which throws
            // exceptions - although this would be bad practice. Catch the exception here
            // and turn it into a WARNING log message so that output does not break.
            if ($recursive) {
                $result = static::recursivelyExtractKey($content, $key, $renderingContext);
            } else {
                $result = static::extractByKey($content, $key, $renderingContext);
            }
        } catch (\RuntimeException $error) {
            throw new Exception($error->getMessage(), $error->getCode(), $error);
        }

        return ($single && is_array($result)) ? reset($result) : $result;
    }

    /**
     * Extract by key
     *
     * @param \Traversable $subject
     * @param string $key
     * @param RenderingContextInterface $renderingContext
     * @return mixed NULL or whatever we found at $key
     * @throws \Exception
     */
    protected static function extractByKey($subject, $key, RenderingContextInterface $renderingContext)
    {
        return TemplateVariableHelper::getInstance()->extractValueFromObjectUsingVariableProviderCopy(
            $subject,
            $key,
            $renderingContext
        );
    }

    /**
     * Recursively extract the key
     *
     * @param \Traversable $subject
     * @param string $key
     * @param RenderingContextInterface $renderingContext
     * @return mixed[]
     * @throws \Exception
     */
    protected static function recursivelyExtractKey($subject, $key, RenderingContextInterface $renderingContext)
    {
        $content = [];

        foreach ($subject as $value) {
            // Lets see if we find something directly...
            $result = TemplateVariableHelper::getInstance()->extractValueFromObjectUsingVariableProviderCopy(
                $value,
                $key,
                $renderingContext
            );
            if ($result !== null) {
                $content[] = $result;
            } elseif (is_array($value) || $value instanceof \Traversable) {
                // ...or we need to recurse to extract
                $content[] = static::recursivelyExtractKey($value, $key, $renderingContext);
            }
        }

        $content = static::flattenArray($content);

        return $content;
    }

    /**
     * Flatten the result structure, to iterate it cleanly in fluid
     *
     * @param array $content
     * @param array $flattened
     * @return array
     */
    protected static function flattenArray(array $content, $flattened = null)
    {
        foreach ($content as $sub) {
            if (is_array($sub)) {
                $flattened = static::flattenArray($sub, $flattened);
            } else {
                $flattened[] = $sub;
            }
        }

        return $flattened;
    }
}
