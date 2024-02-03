<?php

namespace Flynt\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Creates the placeholder image function to use them in Twig files.
 */
class TwigExtensionPlaceholderImage extends AbstractExtension
{
    /**
     *  Returns a list of functions to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('placeholderImage', [$this, 'renderPlaceholderImage']),
        ];
    }

    /**
     * Render placeholder image.
     *
     * @param float $width The width of the placeholder image.
     * @param float $height The height of the placeholder image.
     * @param string $color The color of the placeholder image.
     *
     * @return string The placeholder image.
     */
    public function renderPlaceholderImage(float $width, float $height, string $color = null): string
    {
        $width = (int) round($width);
        $height = (int) round($height);
        $colorRect = $color ? "<rect width='{$width}' height='{$height}' style='fill:{$color}' />" : '';
        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>{$colorRect}</svg>";
        return "data:image/svg+xml;base64," . base64_encode($svg);
    }
}
