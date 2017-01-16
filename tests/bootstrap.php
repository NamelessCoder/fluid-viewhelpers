<?php

$replacements = [
    'use TYPO3\\CMS\\Fluid\\Core\\ViewHelper\\Facets\\CompilableInterface;' . PHP_EOL => '',
    ' implements CompilableInterface'  => '',
    'FluidTYPO3/Vhs' => 'TYPO3/FluidViewHelpers',
    'FluidTYPO3\\Vhs\\' => 'TYPO3\\FluidViewHelpers\\',
    'TYPO3\\CMS\\Fluid\\' => 'TYPO3Fluid\\Fluid\\',
    'extends AbstractViewHelperTest' . PHP_EOL => 'extends AbstractViewHelperTestCase',
    'AbstractViewHelperTest;' . PHP_EOL => 'AbstractViewHelperTestCase;',
    '`v:' => '`f:',
    '<v:' => '<f:',
    '{v:' => '{f:',
    '-> v:' => '-> f:'
];

$functionalTestTemplate = <<< HERE
<?php
namespace TYPO3\FluidViewHelpers\Tests\Functional\ViewHelpers%s;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */
%s
/**
 * Class %s
 */
class %s extends AbstractFunctionalTestCase
{
    /**
     * @return array
     */
    protected function getVariables()
    {
        return [];
    }
}

HERE;

$fixtureFileTemplate = <<< HERE
<f:section name="Test">

</f:section>

<f:section name="Expected">

</f:section>

HERE;

$finder = (function($path) use (&$finder) {
    $files = scandir($path);
    $return = [];
    foreach ($files as $file) {
        if (substr($file, 0, 1) === '.') {
            continue;
        }
        $absolute = realpath($path . '/' . $file);
        if (is_dir($absolute)) {
            $return = array_merge($return, $finder($absolute . '/'));
        } elseif (pathinfo($absolute, PATHINFO_EXTENSION) === 'php') {
            $return[] = $absolute;
        }
    }
    return $return;
});

$files = $finder(realpath(__DIR__ . '/../src/') . '/');

(function() use ($files, $functionalTestTemplate, $fixtureFileTemplate) {
    $prefix = realpath(__DIR__ . '/../src/ViewHelpers/') . '/';
    $fixturesPath = realpath(__DIR__ . '/../tests/Functional/Fixtures/') . '/';
    $testsPath = realpath(__DIR__ . '/../tests/Functional/ViewHelpers/') . '/';
    foreach ($files as $file) {
        if (!is_file($file)) {
            continue;
        }
        if (!strpos($file, '/ViewHelpers/')) {
            continue;
        }
        $subPath = str_replace($prefix, '', $file);
        $functionalTestFile = $testsPath . str_replace('.php', 'FunctionalTest.php', $subPath);
        if (!file_exists($functionalTestFile)) {
            if (!is_dir(dirname($functionalTestFile))) {
                mkdir(dirname($functionalTestFile), 0777, true);
            }
            $directory = ltrim(dirname($subPath), '.');
            if ($directory) {
                $directory = '\\' . str_replace('/', '\\', $directory);
                $import = PHP_EOL . 'use \\TYPO3\\FluidViewHelpers\\Tests\\Functional\\ViewHelpers\\AbstractFunctionalTestCase;' . PHP_EOL;
            } else {
                $import = '';
            }
            $class = str_replace('.php', 'FunctionalTest', basename($subPath));
            $functionalTestSource = sprintf(
                $functionalTestTemplate,
                $directory,
                $import,
                $class,
                $class
            );
            file_put_contents($functionalTestFile, $functionalTestSource);
        }
        $subPath = str_replace('.php', '.html', $subPath);
        $fixtureFile = $fixturesPath . $subPath;
        if (!file_exists($fixtureFile)) {
            if (!is_dir(dirname($fixtureFile))) {
                mkdir(dirname($fixtureFile), 0777, true);
            }
            file_put_contents($fixtureFile, $fixtureFileTemplate);
        }
    }
})();

$files = array_merge($files, $finder(realpath(__DIR__ . '/Unit/') . '/'));

(function() use ($replacements, $files) {
    foreach ($files as $file) {
        $contents = file_get_contents($file);
        $replaced = strtr($contents, $replacements);
        if ($contents !== $replaced) {
            file_put_contents($file, $replaced);
        }
    }
})();
