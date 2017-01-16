<?php
namespace TYPO3\FluidViewHelpers\Helpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * Class ArrayHelper
 *
 * Contains methods to help ViewHelpers with common
 * array-related operations such as CSV conversion.
 */
class ArrayHelper
{
    /**
     * @return ArrayHelper
     */
    public static function getInstance()
    {
        return new static();
    }

    /**
     * Convert a value from any supported type to an array,
     * with or without respect for keys (when input is traversable)
     *
     * @param mixed $candidate
     * @param boolean $useKeys
     * @return array
     * @throws Exception
     */
    public function arrayFromArrayOrTraversableOrCSV($candidate, $useKeys = true)
    {
        if ($candidate instanceof \Traversable) {
            return iterator_to_array($candidate, $useKeys);
        } elseif (is_string($candidate)) {
            return array_map('trim', explode(',', $candidate));
        } elseif (is_array($candidate)) {
            return $candidate;
        } elseif (is_scalar($candidate)) {
            return [$candidate];
        } elseif ($candidate === null) {
            return [];
        }
        throw new Exception(sprintf('Unsupported input type %s; cannot convert to array!', gettype($candidate)));
    }
}
