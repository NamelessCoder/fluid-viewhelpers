<?php
namespace TYPO3\FluidViewHelpers\Helpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Contains methods to help with building of HTML/XML tags.
 */
class TagHelper
{
    /**
     * @return TagHelper
     */
    public static function getInstance()
    {
        return new static();
    }

    /**
     * @param string $tagName
     * @param array $attributes
     * @param string $content
     * @return TagBuilder
     */
    public function prepareTagBuilder($tagName, array $attributes, $content = null)
    {
        // process some attributes differently - if empty, remove the property:
        $builder = new TagBuilder();
        foreach ($attributes as $propertyName => $propertyValue) {
            if (true === empty($propertyValue)) {
                $builder->removeAttribute($propertyName);
            } else {
                $builder->addAttribute($propertyName, $propertyValue);
            }
        }
        $builder->addAttributes($attributes);
        $builder->setTagName($tagName);
        if ($content) {
            $builder->setContent($content);
        }
        return $builder;
    }

    /**
     * Renders a full tag with attributes and content, if provided.
     *
     * @param string $tagName
     * @param array $attributes
     * @param string $content
     * @param boolean $forceClosingTag
     * @return string
     */
    public function renderTag($tagName, array $attributes, $content = null, $forceClosingTag = false)
    {
        $builder = $this->prepareTagBuilder($tagName, $attributes, $content);
        $builder->forceClosingTag($forceClosingTag);
        return $builder->render();
    }

}
