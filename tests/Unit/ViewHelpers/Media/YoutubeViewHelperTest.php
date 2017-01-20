<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Media;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;
/**
 * Class YoutubeViewHelperTest
 */
class YoutubeViewHelperTest extends AbstractViewHelperTestCase{

    /**
     * @var array
     */
    protected $arguments = [
        'videoId' => '',
        'width' => 640,
        'height' => 385,
        'autoplay' => false,
        'legacyCode' => false,
        'showRelated' => false,
        'extendedPrivacy' => true,
        'hideControl' => false,
        'hideInfo' => false,
        'playlist' => '',
        'loop' => false,
        'start' => 30,
        'end' => '',
        'lightTheme' => false,
        'videoQuality' => ''
    ];

    /**
     * @test
     */
    public function compareResult()
    {
        $this->arguments['videoId']  = 'M7lc1UVf-VE';
        $this->arguments['hideInfo'] = true;
        $this->arguments['start']    = 30;

        preg_match('#src="([^"]*)"#', $this->executeViewHelper($this->arguments), $actualSource);
        $expectedSource = '//www.youtube-nocookie.com/embed/M7lc1UVf-VE?rel=0&amp;showinfo=0&amp;start=30';

        $this->assertSame($expectedSource, $actualSource[1]);
    }
}
