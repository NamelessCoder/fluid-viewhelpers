<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Generate\System;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ### System: UNIX Timestamp
 *
 * Returns the current system UNIX timestamp as integer.
 * Useful combined with the Math group of ViewHelpers:
 *
 *     <!-- adds exactly one hour to a DateTime and formats it -->
 *     <f:format.date format="H:i">{dateTime.timestamp -> f:math.sum(b: 3600)}</f:format.date>
 */
class TimestampViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

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
        return time();
    }
}
