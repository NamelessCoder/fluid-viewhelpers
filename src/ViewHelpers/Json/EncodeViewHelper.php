<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Json;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * ### JSON Encoding ViewHelper
 *
 * Returns a string containing the JSON representation of the argument.
 * The argument may be any of the following types:
 *
 * - arrays, associative and traditional
 * - standard types (string, integer, boolean, float, NULL)
 * - DateTime including ones found as property values on DomainObjects
 *
 * Be specially careful when you JSON encode custom objects which have
 * recursive relations to itself using either 1:n or m:n - in this case
 * the one member of the converted relation will be whichever value you
 * specified as "recursionMarker" - or the default value, NULL. When
 * using the output of such conversion in JavaScript please make sure you
 * check the type before assuming that every member of a converted 1:n
 * or m:n recursive relation is in fact a JavaScript. Not doing so may
 * result in fatal JavaScript errors in the client browser.
 */
class EncodeViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var array
     */
    protected static $encounteredClasses = [];

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('value', 'mixed', 'Value to encode as JSON');
        $this->registerArgument(
            'useTraversableKeys',
            'boolean',
            'If TRUE, preserves keys from Traversables converted to arrays. Not recommended for ObjectStorages!',
            false,
            false
        );
        $this->registerArgument(
            'preventRecursion',
            'boolean',
            'If FALSE, allows recursion to occur which could potentially be fatal to the output unless managed',
            false,
            true
        );
        $this->registerArgument(
            'recursionMarker',
            'mixed',
            'Any value - string, integer, boolean, object or NULL - inserted instead of recursive instances of objects'
        );
        $this->registerArgument(
            'dateTimeFormat',
            'string',
            'A date() format for DateTime values to JSON-compatible values. NULL means JS UNIXTIME (time()*1000)'
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
        $useTraversableKeys = (boolean) $arguments['useTraversableKeys'];
        $preventRecursion = (boolean) $arguments['preventRecursion'];
        $recursionMarker = $arguments['recursionMarker'];
        $dateTimeFormat = $arguments['dateTimeFormat'];
        if (true === empty($value)) {
            return '{}';
        }
        static::$encounteredClasses = [];
        $json = static::encodeValue($value, $useTraversableKeys, $preventRecursion, $recursionMarker, $dateTimeFormat);
        return $json;
    }

    /**
     * @param mixed $value
     * @param boolean $useTraversableKeys
     * @param boolean $preventRecursion
     * @param string $recursionMarker
     * @param string $dateTimeFormat
     * @return mixed
     */
    protected static function encodeValue($value, $useTraversableKeys, $preventRecursion, $recursionMarker, $dateTimeFormat)
    {
        if ($value instanceof \Traversable) {
            // Note: also converts ObjectStorage to \Vendor\Extname\Domain\Model\ObjectType[] which are each converted
            $value = iterator_to_array($value, $useTraversableKeys);
        } elseif ($value instanceof \DateTime) {
            $value = static::dateTimeToUnixtimeMiliseconds($value, $dateTimeFormat);
        }

        // process output of conversion, catching specially supported object types such as DomainObject and DateTime
        if (is_array($value)) {
            $value = static::recursiveDateTimeToUnixtimeMiliseconds($value, $dateTimeFormat);
        };
        $json = json_encode($value, JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_TAG);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception('The provided argument cannot be converted into JSON.', 1358440181);
        }
        return $json;
    }

    /**
     * Converts any encountered DateTime instances to UNIXTIME timestamps
     * which are then multiplied by 1000 to create a JavaScript appropriate
     * time stamp - ready to be loaded into a Date object client-side.
     *
     * Works on already converted DomainObjects which are at this point just
     * associative arrays of values - which might be DateTime instances.
     *
     * @param array $array
     * @param string $dateTimeFormat
     * @return array
     */
    protected static function recursiveDateTimeToUnixtimeMiliseconds(array $array, $dateTimeFormat)
    {
        foreach ($array as $key => $possibleDateTime) {
            if (true === $possibleDateTime instanceof \DateTime) {
                $array[$key] = static::dateTimeToUnixtimeMiliseconds($possibleDateTime, $dateTimeFormat);
            } elseif (true === is_array($possibleDateTime)) {
                $array[$key] = static::recursiveDateTimeToUnixtimeMiliseconds($array[$key], $dateTimeFormat);
            }
        }
        return $array;
    }

    /**
     * Formats a single DateTime instance to whichever value is demanded by
     * the format specified in $dateTimeFormat (DateTime::format syntax).
     * Default format is NULL a JS UNIXTIME (time()*1000) is produced.
     *
     * @param \DateTime $dateTime
     * @param string $dateTimeFormat
     * @return integer
     */
    protected static function dateTimeToUnixtimeMiliseconds(\DateTime $dateTime, $dateTimeFormat)
    {
        if (null === $dateTimeFormat) {
            return intval($dateTime->format('U')) * 1000;
        }
        return $dateTime->format($dateTimeFormat);
    }
}
