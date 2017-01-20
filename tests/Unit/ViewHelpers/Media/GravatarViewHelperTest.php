<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Media;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class GravatarViewHelperTest
 */
class GravatarViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @var array
     */
    protected $arguments = [
        'email' => 'juanmanuel.vergessolanas@gmail.com',
        'secure' => false,
    ];

    /**
     * @test
     */
    public function generatesExpectedImgForEmailAddress()
    {
        $expectedSource = 'http://www.gravatar.com/avatar/b1b0eddcbc4468db89f355ebb9cc3007';
        preg_match('#src="([^"]*)"#', $this->executeViewHelper($this->arguments), $actualSource);
        $this->assertSame($expectedSource, $actualSource[1]);
        $expectedSource = 'https://secure.gravatar.com/avatar/b1b0eddcbc4468db89f355ebb9cc3007?s=160&amp;d=404&amp;r=pg';
        $this->arguments = [
            'email' => 'juanmanuel.vergessolanas@gmail.com',
            'size' => 160,
            'imageSet' => '404',
            'maximumRating' => 'pg',
            'secure' => true,
        ];
        preg_match('#src="([^"]*)"#', $this->executeViewHelper($this->arguments), $actualSource);
        $this->assertSame($expectedSource, $actualSource[1]);
    }
}
