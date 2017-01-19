<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Image;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Returns the mimetype of the provided image file.
 */
class MimetypeViewHelper extends AbstractViewHelper
{
    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('src', 'mixed', 'Path to image file - if not provided, taken from tag content');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return integer
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return getimagesize($renderChildrenClosure())[2];
    }
}
