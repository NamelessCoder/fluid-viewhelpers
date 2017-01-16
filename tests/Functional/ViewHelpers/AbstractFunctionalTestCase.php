<?php
namespace TYPO3\FluidViewHelpers\Tests\Functional\ViewHelpers;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * Class AbstractFunctionalTestCase
 */
abstract class AbstractFunctionalTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    protected function getVariables()
    {
        return [];
    }

    /**
     * @test
     */
    public function test()
    {
        $templateView = new TemplateView();
        $templateView->getRenderingContext()->getTemplatePaths()->setTemplatePathAndFilename($this->resolveFilename());
        $templateView->getRenderingContext()->getViewHelperResolver()->addNamespace('f', 'TYPO3\\FluidViewHelpers\\ViewHelpers');
        $templateView->render();
        $variables = $this->getVariables();
        $expected = $templateView->renderSection('Expected', $variables);
        $result = $templateView->renderSection('Test', $variables);
        $this->assertSame($expected, $result);
    }

    /**
     * @return string
     */
    protected function resolveFilename()
    {
        $fixturesPath = realpath(__DIR__ . '/../Fixtures') . '/';
        $class = get_class($this);
        $fixtureName = str_replace('TYPO3\\FluidViewHelpers\\Tests\\Functional\\ViewHelpers\\', '', $class);
        $fixtureName = str_replace('\\', '/', $fixtureName);
        $fixtureName = substr($fixtureName, 0, -14);
        return $fixturesPath . $fixtureName . '.html';
    }

}
