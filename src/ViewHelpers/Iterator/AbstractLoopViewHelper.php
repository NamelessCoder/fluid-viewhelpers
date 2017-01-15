<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Iterator;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Abstract class with basic functionality for loop view helpers.
 */
abstract class AbstractLoopViewHelper extends AbstractViewHelper
{
    /**
     * Initialize
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('iteration', 'string', 'Name of template variable which will contain iteration info');
    }

    /**
     * @param integer $i
     * @param integer $from
     * @param integer $to
     * @param integer $step
     * @param string $iterationArgument
     * @param RenderingContextInterface $renderingContext
     * @param \Closure $renderChildrenClosure
     * @return string
     */
    protected static function renderIteration(
        $i,
        $from,
        $to,
        $step,
        $iterationArgument,
        RenderingContextInterface $renderingContext,
        \Closure $renderChildrenClosure
    ) {
        if (empty($iterationArgument)) {
            return $renderChildrenClosure();
        }
        $variableProvider = $renderingContext->getVariableProvider();
        $cycle = intval(($i - $from) / $step) + 1;
        $iteration = [
            'index' => $i,
            'cycle' => $cycle,
            'isOdd' => (0 === $cycle % 2 ? false : true),
            'isEven' => (0 === $cycle % 2 ? true : false),
            'isFirst' => ($i === $from ? true : false),
            'isLast' => static::isLast($i, $from, $to, $step)
        ];
        $variableProvider->add($iterationArgument, $iteration);
        #var_dump($renderChildrenClosure());
        $content = $renderChildrenClosure();
        $variableProvider->remove($iterationArgument);
        return $content;
    }

    /**
     * @param integer $i
     * @param integer $from
     * @param integer $to
     * @param integer $step
     * @return boolean
     */
    protected static function isLast($i, $from, $to, $step)
    {
        if ($from === $to) {
            $isLast = true;
        } elseif ($from < $to) {
            $isLast = ($i + $step > $to);
        } else {
            $isLast = ($i + $step < $to);
        }

        return $isLast;
    }
}
