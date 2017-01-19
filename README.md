Universal Fluid ViewHelpers
===========================

> **IMPORTANT** this is work in progress and may not be fully ready until Fluid 3.0 is released and can
> be used as minimum requirement.

Library of universal, general-purpose ViewHelpers compatible with the standalone Fluid template engine.

Usage
-----

On command line:

`composer require typo3/fluid-viewhelpers`

And to register, via PHP API:

`$view->getRenderingContext()->getViewHelperResolver()->addNamespace('f', 'TYPO3\\FluidViewHelpers\ViewHelpers');`

Or in your template file(s):

`{namespace f=TYPO3\\FluidViewHelpers\ViewHelpers}`

Registering the namespace appends the ViewHelpers from this package to the `f:` namespace - you can also register
the namespace under a different alias. However, appending this library to the built-in ViewHelpers of Fluid has some
benefits, among other things it makes it possible to generate a single schema file containing all ViewHelpers.


