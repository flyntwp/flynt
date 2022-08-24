<?php

namespace Flynt\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtensionPlaceholderImage extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('placeholderImage', [$this, 'renderPlaceholderImage']),
        ];
    }

    public function renderPlaceholderImage($width, $height, $color = null)
    {
        $width = round($width);
        $height = round($height);
        $colorRect = $color ? "<rect width='{$width}' height='{$height}' style='fill:$color' />" : '';
        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>{$colorRect}</svg>";
        return "data:image/svg+xml;base64," . base64_encode($svg);
    }
}
