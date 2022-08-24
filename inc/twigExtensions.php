<?php

/**
 * Add Twig extensions.
 */

namespace Flynt\TwigExtensions;

use Flynt\Utils\TwigExtensionRenderComponent;
use Flynt\Utils\TwigExtensionReadingTime;
use Flynt\Utils\TwigExtensionPlaceholderImage;
use Flynt\Utils\TwigExtensionHtmlAttribute;

add_filter('get_twig', function ($twig) {
    $twig->addExtension(new TwigExtensionRenderComponent());
    $twig->addExtension(new TwigExtensionReadingTime());
    $twig->addExtension(new TwigExtensionPlaceholderImage());
    $twig->addExtension(new TwigExtensionHtmlAttribute());
    return $twig;
});
