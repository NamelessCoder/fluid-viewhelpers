<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Media;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\TagHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Renders HTML code to embed a video from YouTube.
 */
class YoutubeViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * Base url
     *
     * @var string
     */
    const YOUTUBE_BASEURL = '//www.youtube.com';

    /**
     * Base url for extended privacy
     *
     * @var string
     */
    const YOUTUBE_PRIVACY_BASEURL = '//www.youtube-nocookie.com';

    /**
     * @var string
     */
    protected $tagName = 'iframe';

    /**
     * Initialize arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        $this->registerArgument('videoId', 'string', 'YouTube id of the video to embed.', true);
        $this->registerArgument(
            'width',
            'integer',
            'Width of the video in pixels. Defaults to 640 for 16:9 content.',
            false,
            640
        );
        $this->registerArgument(
            'height',
            'integer',
            'Height of the video in pixels. Defaults to 385 for 16:9 content.',
            false,
            385
        );
        $this->registerArgument(
            'autoplay',
            'boolean',
            'Play the video automatically on load. Defaults to FALSE.',
            false,
            false
        );
        $this->registerArgument('legacyCode', 'boolean', 'Whether to use the legacy flash video code.', false, false);
        $this->registerArgument(
            'showRelated',
            'boolean',
            'Whether to show related videos after playing.',
            false,
            false
        );
        $this->registerArgument('extendedPrivacy', 'boolean', 'Whether to use cookie-less video player.', false, true);
        $this->registerArgument('hideControl', 'boolean', 'Hide video player\'s control bar.', false, false);
        $this->registerArgument('hideInfo', 'boolean', 'Hide video player\'s info bar.', false, false);
        $this->registerArgument('enableJsApi', 'boolean', 'Enable YouTube JavaScript API', false, false);
        $this->registerArgument('playlist', 'string', 'Comma seperated list of video IDs to be played.');
        $this->registerArgument('loop', 'boolean', 'Play the video in a loop.', false, false);
        $this->registerArgument('start', 'integer', 'Start playing after seconds.');
        $this->registerArgument('end', 'integer', 'Stop playing after seconds.');
        $this->registerArgument('lightTheme', 'boolean', 'Use the YouTube player\'s light theme.', false, false);
        $this->registerArgument(
            'videoQuality',
            'string',
            'Set the YouTube player\'s video quality (hd1080,hd720,highres,large,medium,small).'
        );
        $this->registerArgument(
            'windowMode',
            'string',
            'Set the Window-Mode of the YouTube player (transparent,opaque). This is necessary for ' .
            'z-index handling in IE10/11.',
            false
        );
    }

    /**
     * Render method
     *
     * @return string
     */
    public function render()
    {
        $videoId = $this->arguments['videoId'];
        $width = $this->arguments['width'];
        $height = $this->arguments['height'];

        $this->tag->addAttribute('width', $width);
        $this->tag->addAttribute('height', $height);

        $src = $this->getSourceUrl($videoId);

        if (!$this->arguments['legacyCode']) {
            $this->tag->addAttribute('src', $src);
            $this->tag->addAttribute('frameborder', '0');
            $this->tag->addAttribute('allowFullScreen', 'allowFullScreen');
            $this->tag->forceClosingTag(true);
        } else {
            $this->tag->setTagName('object');

            $tagContent = '';

            $paramAttributes = [
                'movie' => $src,
                'allowFullScreen' => 'true',
                'scriptAccess' => 'always',
            ];
            foreach ($paramAttributes as $name => $value) {
                $tagContent .= TagHelper::getInstance()->renderTag('param', [$name => $value], null, true);
            }

            $embedAttributes = [
                'src' => $src,
                'type' => 'application/x-shockwave-flash',
                'width' => (string) $width,
                'height' => (string) $height,
                'allowFullScreen' => 'true',
                'scriptAccess' => 'always',
            ];
            $tagContent .= TagHelper::getInstance()->renderTag('embed', $embedAttributes, null, true);

            $this->tag->setContent($tagContent);
        }

        return $this->tag->render();
    }

    /**
     * Returns video source url according to provided arguments
     *
     * @param string $videoId
     * @return string
     */
    private function getSourceUrl($videoId)
    {
        $src = $this->arguments['extendedPrivacy'] ? static::YOUTUBE_PRIVACY_BASEURL : static::YOUTUBE_BASEURL;

        $params = [];

        if (!$this->arguments['showRelated']) {
            $params[] = 'rel=0';
        }
        if ($this->arguments['autoplay']) {
            $params[] = 'autoplay=1';
        }
        if ($this->arguments['hideControl']) {
            $params[] = 'controls=0';
        }
        if ($this->arguments['hideInfo']) {
            $params[] = 'showinfo=0';
        }
        if ($this->arguments['enableJsApi']) {
            $params[] = 'enablejsapi=1';
        }
        if (!empty($this->arguments['playlist'])) {
            $params[] = 'playlist=' . $this->arguments['playlist'];
        }
        if ($this->arguments['loop']) {
            $params[] = 'loop=1';
        }
        if (!empty($this->arguments['start'])) {
            $params[] = 'start=' . $this->arguments['start'];
        }
        if (!empty($this->arguments['end'])) {
            $params[] = 'end=' . $this->arguments['end'];
        }
        if ($this->arguments['lightTheme']) {
            $params[] = 'theme=light';
        }
        if (!empty($this->arguments['videoQuality'])) {
            $params[] = 'vq=' . $this->arguments['videoQuality'];
        }
        if (!empty($this->arguments['windowMode'])) {
            $params[] = 'wmode=' . $this->arguments['windowMode'];
        }

        if (!$this->arguments['legacyCode']) {
            $src .= '/embed/'. $videoId;
            $separator = '?';
        } else {
            $src .= '/v/' . $videoId . '?version=3';
            $separator = '&';
        }

        if (!empty($params)) {
            $src .= $separator . implode('&', $params);
        }

        return $src;
    }
}
