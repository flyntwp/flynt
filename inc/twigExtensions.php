<?php

/**
 * Add Twig extensions.
 */

namespace Flynt\TwigExtensions;

use Flynt\Utils\TwigExtensionRenderComponent;
use Flynt\Utils\TwigExtensionReadingTime;
use Flynt\Utils\TwigExtensionPlaceholderImage;
use Twig\Environment;

add_filter('timber/twig', function (Environment $twig): Environment {
    $twig->addExtension(new TwigExtensionRenderComponent());
    $twig->addExtension(new TwigExtensionReadingTime());
    $twig->addExtension(new TwigExtensionPlaceholderImage());
    return $twig;
});
