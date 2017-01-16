<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Variable;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * ### Variable: Environment
 *
 * Reads variable from `$_ENV` identified by name argument.
 *
 * Usage:
 *
 *     <f:variable.environment name="MY_ENVIRONMENT_VARIABLE" />
 *     {f:variable.environment(name: 'MY_ENVIRONMENT_VARIABLE')}
 */
class EnvironmentViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('name', 'string', 'Name of environment variable to retrieve');
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
        return getenv($renderChildrenClosure());
    }
}
