<?php
namespace TYPO3\FluidViewHelpers\ViewHelpers\Media;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Helpers\ArrayHelper;
use TYPO3\FluidViewHelpers\Helpers\TagHelper;
use TYPO3\FluidViewHelpers\Traits\TagViewHelperTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * Renders HTML code to embed a HTML5 video player. NOTICE: This is
 * all HTML5 and won't work on browsers like IE8 and below. Include
 * some helper library like videojs.com if you need to suport those.
 * Source can be a single file, a CSV of files or an array of arrays
 * with multiple sources for different video formats. In the latter
 * case provide array keys 'src' and 'type'. Providing an array of
 * sources (even for a single source) is preferred as you can set
 * the correct mime type of the video which is otherwise guessed
 * from the filename's extension.
 */
class VideoViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'video';

    /**
     * @var array
     */
    protected $validTypes = ['mp4', 'webm', 'ogg', 'ogv'];

    /**
     * @var array
     */
    protected $mimeTypesMap = [
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'ogg' => 'video/ogg',
        'ogv' => 'video/ogg'
    ];

    /**
     * @var array
     */
    protected $validPreloadModes = ['auto', 'metadata', 'none'];

    /**
     * Initialize arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerArgument(
            'src',
            'mixed',
            'Path to the media resource(s). Can contain single or multiple paths for videos/audio (either CSV, ' .
            'array or implementing Traversable).',
            true
        );
        $this->registerArgument('width', 'integer', 'Sets the width of the video player in pixels.', true);
        $this->registerArgument('height', 'integer', 'Sets the height of the video player in pixels.', true);
        $this->registerArgument(
            'autoplay',
            'boolean',
            'Specifies that the video will start playing as soon as it is ready.',
            false,
            false
        );
        $this->registerArgument(
            'controls',
            'boolean',
            'Specifies that video controls should be displayed (such as a play/pause button etc).',
            false,
            false
        );
        $this->registerArgument(
            'loop',
            'boolean',
            'Specifies that the video will start over again, every time it is finished.',
            false,
            false
        );
        $this->registerArgument(
            'muted',
            'boolean',
            'Specifies that the audio output of the video should be muted.',
            false,
            false
        );
        $this->registerArgument(
            'poster',
            'string',
            'Specifies an image to be shown while the video is downloading, or until the user hits the play button.'
        );
        $this->registerArgument(
            'preload',
            'string',
            'Specifies if and how the author thinks the video should be loaded when the page loads. Can be ' .
            '"auto", "metadata" or "none".',
            false,
            'auto'
        );
        $this->registerArgument(
            'unsupported',
            'string',
            'Add a message for old browsers like Internet Explorer 9 without video support.'
        );
    }

    /**
     * Render method
     *
     * @throws Exception
     * @return string
     */
    public function render()
    {
        $sources = ArrayHelper::getInstance()->arrayFromArrayOrTraversableOrCSV($this->arguments['src']);
        if (0 === count($sources)) {
            throw new Exception('No video sources provided.', 1359382189);
        }
        $content = $this->tag->getContent();
        foreach ($sources as $source) {
            if (is_string($source)) {
                $src = $source;
                $type = pathinfo($source, PATHINFO_EXTENSION);
            } elseif (is_array($source)) {
                if (!isset($source['src'])) {
                    throw new Exception('Missing value for "src" in sources array.', 1359381250);
                }
                $src = $source['src'];
                if (!isset($source['type'])) {
                    throw new Exception('Missing value for "type" in sources array.', 1359381255);
                }
                $type = $source['type'];
            } else {
                // skip invalid source
                continue;
            }
            if (!in_array(strtolower($type), $this->validTypes)) {
                throw new Exception('Invalid video type "' . $type . '".', 1359381260);
            }
            $type = $this->mimeTypesMap[$type];
            $content .= TagHelper::getInstance()->renderTag('source', ['src' => $src, 'type' => $type]);
        }
        $tagAttributes = [
            'width'   => $this->arguments['width'],
            'height'  => $this->arguments['height'],
            'preload' => 'auto',
        ];
        if ($this->arguments['autoplay']) {
            $tagAttributes['autoplay'] = 'autoplay';
        }
        if ($this->arguments['controls']) {
            $tagAttributes['controls'] = 'controls';
        }
        if ($this->arguments['loop']) {
            $tagAttributes['loop'] = 'loop';
        }
        if ($this->arguments['muted']) {
            $tagAttributes['muted'] = 'muted';
        }
        if (in_array($this->arguments['preload'], $this->validPreloadModes)) {
            $tagAttributes['preload'] = 'preload';
        }
        if (null !== $this->arguments['poster']) {
            $tagAttributes['poster'] = $this->arguments['poster'];
        }
        $this->tag->addAttributes($tagAttributes);
        if (null !== $this->arguments['unsupported']) {
            $this->tag->setContent($content . PHP_EOL . $this->arguments['unsupported']);
        }
        return $this->tag->render();
    }
}
