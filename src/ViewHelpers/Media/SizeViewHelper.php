<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Media;

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
 * Returns the size of the provided file in bytes.
 */
class SizeViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        $this->registerArgument('path', 'string', 'Path to the file to determine size for.');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return integer
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $path = $renderChildrenClosure();

        if (null === $path) {
            return 0;
        }

        $file = realpath($path);

        if (false === file_exists($file) || true === is_dir($file)) {
            throw new Exception(
                'Cannot determine size of "' . $file . '". File does not exist or is a directory.',
                1356953963
            );
        }

        $size = filesize($file);

        if ($size === false) {
            throw new Exception('Cannot determine size of "' . $file . '".', 1356954032);
        }

        return $size;
    }
}
