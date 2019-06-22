<?php

namespace Flynt\TwigReadingTime;

use Flynt\Utils\TwigReadingTimeExtension;

add_filter('get_twig', function ($twig) {
    $twig->addExtension(new TwigReadingTimeExtension());
    return $twig;
});
