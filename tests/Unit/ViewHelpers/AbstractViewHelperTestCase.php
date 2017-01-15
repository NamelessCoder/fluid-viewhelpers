<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\NodeInterface;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ObjectAccessorNode;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ViewHelperNode;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInterface;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * Class AbstractViewHelperTest
 */
abstract class AbstractViewHelperTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function canPrepareArguments()
    {
        $instance = $this->createInstance();
        $arguments = $instance->prepareArguments();
        $this->assertThat($arguments, new \PHPUnit_Framework_Constraint_IsType(\PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY));
    }

    /**
     * @return string
     */
    protected function getViewHelperClassName()
    {
        $class = get_class($this);
        $class = substr($class, 0, -4);
        $class = str_replace('Tests\\Unit\\', '', $class);
        return $class;
    }

    /**
     * @param string $type
     * @param mixed $value
     * @return NodeInterface
     */
    protected function createNode($type, $value)
    {
        /** @var NodeInterface $node */
        $className = 'TYPO3Fluid\\Fluid\\Core\\Parser\\SyntaxTree\\' . $type . 'Node';
        return new $className($value);
    }

    /**
     * @return ViewHelperInterface
     */
    protected function createInstance()
    {
        $className = $this->getViewHelperClassName();
        /** @var ViewHelperInterface $instance */
        $instance = new $className();
        $instance->initialize();
        return $instance;
    }

    /**
     * @param array $arguments
     * @param array $variables
     * @return ViewHelperInterface
     */
    protected function buildViewHelperInstance($arguments = [], $variables = [])
    {
        $instance = $this->createInstance();
        $renderingContext = new RenderingContext(new TemplateView());
        $renderingContext->getVariableProvider()->setSource($variables);
        $instance->setRenderingContext($renderingContext);
        $argumentDefinitions = $instance->prepareArguments();
        foreach ($argumentDefinitions as $argumentName => $argumentDefinition) {
            if (!array_key_exists($argumentName, $arguments)) {
                $arguments[$argumentName] = $argumentDefinition->getDefaultValue();
            }
        }
        $instance->setArguments($arguments);
        return $instance;
    }

    /**
     * @param array $arguments
     * @param array $variables
     * @return mixed
     */
    protected function executeViewHelper($arguments = [], $variables = [])
    {
        $instance = $this->buildViewHelperInstance($arguments, $variables);
        $instance->setViewHelperNode($this->createViewHelperNode($instance));
        return $instance->initializeArgumentsAndRender();
    }

    /**
     * @param array $arguments
     * @param array $variables
     * @param mixed $nodeValue
     * @return mixed
     */
    protected function executeViewHelperUsingTagContent(array $arguments = [], array $variables = [], $nodeValue = null)
    {
        $instance = $this->buildViewHelperInstance($arguments);
        $context = $this->getRenderingContext($instance);
        if (!empty($variables)) {
            $context->getVariableProvider()->setSource($variables);
        }
        if ($nodeValue instanceof NodeInterface) {
            $viewHelperNode = $this->getMockBuilder(ViewHelperNode::class)
                ->disableOriginalConstructor()
                ->getMock();
            $viewHelperNode->addChildNode($nodeValue);
            $instance->setChildNodes([$nodeValue]);
        } else {
            $viewHelperNode = $this->getMockBuilder(ViewHelperNode::class)
                ->setMethods(['evaluateChildNodes'])
                ->disableOriginalConstructor()
                ->getMock();
            $viewHelperNode->expects($this->atLeastOnce())->method('evaluateChildNodes')->willReturn($nodeValue);
        }
        $instance->setViewHelperNode($viewHelperNode);
        return $instance->initializeArgumentsAndRender();
    }

    /**
     * @param ViewHelperInterface $instance
     * @return \PHPUnit_Framework_MockObject_MockObject|ViewHelperNode
     */
    protected function createViewHelperNode($instance)
    {
        $resolver = $this->getMockBuilder(ViewHelperResolver::class)
            ->setMethods(['getUninitializedViewHelper'])
            ->getMock();
        $this->getRenderingContext($instance)->setViewHelperResolver($resolver);
        $node = $this->getMockBuilder(ViewHelperNode::class)
            ->disableOriginalConstructor()
            ->getMock();
        $node->expects($this->any())->method('getUninitializedViewHelper')->willReturn($instance);
        return $node;
    }

    /**
     * @param string $accessor
     * @return ObjectAccessorNode
     */
    protected function createObjectAccessorNode($accessor) {
        return new ObjectAccessorNode($accessor);
    }

    /**
     * @param null|string $message
     * @param null|integer $code
     */
    protected function expectViewHelperException($message = null, $code = null)
    {
        $this->expectException(Exception::class);
        if ($message) {
            $this->expectExceptionMessage($message);
        }
        if ($code) {
            $this->expectExceptionCode($code);
        }
    }

    /**
     * @param object $instance
     * @param string $method
     * @param array ...$arguments
     * @return mixed
     */
    protected function callInaccessibleMethod($instance, $method, ...$arguments)
    {
        $method = new \ReflectionMethod($instance, $method);
        $method->setAccessible(true);
        return $method->invokeArgs($method->isStatic() ? $instance : null, $arguments);
    }

    /**
     * @param ViewHelperInterface $instance
     * @return RenderingContext
     */
    public function getRenderingContext(ViewHelperInterface $instance)
    {
        $reflection = new \ReflectionProperty($instance, 'renderingContext');
        $reflection->setAccessible(true);
        return $reflection->getValue($instance);
    }
}
