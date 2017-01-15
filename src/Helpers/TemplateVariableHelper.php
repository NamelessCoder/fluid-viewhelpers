<?php
namespace TYPO3\FluidViewHelpers\Helpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\Variables\VariableProviderInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ArgumentDefinition;

/**
 * Class TemplateVariableHelper
 *
 * Contains methods to help ViewHelpers do common operations
 * related to template variables.
 */
class TemplateVariableHelper
{
    /**
     * @return TemplateVariableHelper
     */
    public static function getInstance()
    {
        return new static();
    }

    /**
     * @param array $definitions
     * @return ArgumentDefinition
     */
    public function createAsArgumentDefinition(array &$definitions)
    {
        $definitions['as'] = new ArgumentDefinition('as', 'string', 'Template variable to assign', false);
    }

    /**
     * @param mixed $subject
     * @param string $key
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public function extractValueFromObjectUsingVariableProviderCopy(
        $subject,
        $key,
        RenderingContextInterface $renderingContext
    ) {
        return $renderingContext->getVariableProvider()
            ->getScopeCopy(['subject' => $subject])
            ->getByPath('subject.' . $key);
    }

    /**
     * @param mixed $variable
     * @param string $as
     * @param RenderingContextInterface $renderingContext
     * @param \Closure $renderChildrenClosure
     * @return mixed
     */
    public function renderChildrenWithVariableOrReturnInput(
        $variable,
        $as,
        RenderingContextInterface $renderingContext,
        \Closure $renderChildrenClosure
    ) {
        if (true === empty($as)) {
            return $variable;
        } else {
            $variables = [$as => $variable];
            $content = $this->renderChildrenWithVariables(
                $variables,
                $renderingContext->getVariableProvider(),
                $renderChildrenClosure
            );
        }
        return $content;
    }

    /**
     * Renders tag content of ViewHelper and inserts variables
     * in $variables into $variableContainer while keeping backups
     * of each existing variable, restoring it after rendering.
     * Returns the output of the renderChildren() method on $viewHelper.
     *
     * @param array $variables
     * @param VariableProviderInterface $variableProvider
     * @param \Closure $renderChildrenClosure
     * @return mixed
     */
    public function renderChildrenWithVariables(
        array $variables,
        $variableProvider,
        $renderChildrenClosure
    ) {
        $backups = $this->backupVariables($variables, $variableProvider);
        $content = $renderChildrenClosure();
        $this->restoreVariables($variables, $backups, $variableProvider);
        return $content;
    }

    /**
     * @param array $variables
     * @param VariableProviderInterface $variableProvider
     * @return array
     */
    private function backupVariables(array $variables, $variableProvider)
    {
        $backups = [];
        foreach ($variables as $variableName => $variableValue) {
            if (true === $variableProvider->exists($variableName)) {
                $backups[$variableName] = $variableProvider->get($variableName);
                $variableProvider->remove($variableName);
            }
            $variableProvider->add($variableName, $variableValue);
        }
        return $backups;
    }

    /**
     * @param array $variables
     * @param array $backups
     * @param VariableProviderInterface $variableProvider
     * @return void
     */
    private function restoreVariables(array $variables, array $backups, $variableProvider)
    {
        foreach ($variables as $variableName => $variableValue) {
            $variableProvider->remove($variableName);
            if (true === isset($backups[$variableName])) {
                $variableProvider->add($variableName, $variableValue);
            }
        }
    }
}
