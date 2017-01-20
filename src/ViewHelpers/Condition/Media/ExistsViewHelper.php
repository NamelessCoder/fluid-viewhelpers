<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Media;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * File/Directory Exists Condition ViewHelper.
 *
 * Can be used with "file" argument alone, or with "directory"
 * argument alone, or with both specified. If both are specified,
 * both must exist and the directory must be a directory for the
 * condition to be true.
 */
class ExistsViewHelper extends AbstractConditionViewHelper
{
    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('file', 'string', 'Filename which must exist');
        $this->registerArgument('directory', 'string', 'Directory which must exist and must be a directory');
    }

    /**
     * This method decides if the condition is TRUE or FALSE. It can be overriden in
     * extending viewhelpers to adjust functionality.
     *
     * @param array $arguments
     * @return boolean
     */
    protected static function evaluateCondition($arguments = null)
    {
        $file = realpath($arguments['file']);
        $directory = $arguments['directory'];
        if ($file) {
            return (!$directory ? file_exists($file) : file_exists($file) && is_dir($directory));
        }
        if ($directory) {
            return (!$file ? is_dir($directory) : is_dir($directory) && file_exists($file));
        }
        throw new Exception(
            'Either "file" or "directory" or both must be provided for ' . static::class,
            1484915630
        );
    }
}
