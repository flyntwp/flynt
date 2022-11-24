<?php

/**
 * Add Twig extensions.
 */

namespace Flynt\TwigExtensions;

use Flynt\Utils\TwigExtensionRenderComponent;
use Flynt\Utils\TwigExtensionReadingTime;
use Flynt\Utils\TwigExtensionPlaceholderImage;

add_filter('timber/twig', function ($twig) {
    $twig->addExtension(new TwigExtensionRenderComponent());
    $twig->addExtension(new TwigExtensionReadingTime());
    $twig->addExtension(new TwigExtensionPlaceholderImage());
    return $twig;
});
