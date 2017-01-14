Universal Fluid ViewHelpers
===========================

Library of universal, general-purpose ViewHelpers compatible with the standalone Fluid template engine.

Usage
-----

On command line:

`composer require typo3/fluid-viewhelpers`

And to register, via PHP API:

`$view->getRenderingContext()->getViewHelperResolver()->addNamespace('f', 'TYPO3\\FluidViewHelpers');`

Or in your template file(s):

`{namespace f=TYPO3\\FluidViewHelpers\ViewHelpers}`

Note that when adding via PHP API, the `ViewHelpers` sub-namespace is automatically appended. When adding it via Fluid
template files, the suffix is still required.

Registering the namespace appends the ViewHelpers from this package to the `f:` namespace - you can also register
the namespace under a different alias. However, appending this library to the built-in ViewHelpers of Fluid has some
benefits, among other things it makes it possible to generate a single schema file containing all ViewHelpers.


