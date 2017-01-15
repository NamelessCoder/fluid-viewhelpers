<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Implode ViewHelper
 *
 * Implodes an array or array-convertible object by $glue.
 */
class ImplodeViewHelper extends ExplodeViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var string
     */
    protected static $method = 'implode';

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Initialize
     *
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->overrideArgument('content', 'string', 'Array or array-convertible object to be imploded by glue');
    }
}
