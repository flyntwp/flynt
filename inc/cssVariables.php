<?php

/**
 * Output CSS variables in head before the main stylesheet.
 */

namespace Flynt\CSSVariables;

use Flynt\Utils\ColorHelpers;
use Flynt\Variables;

add_action('wp_head', function () {
    $themes = Variables\getColors();
    $sizes = Variables\getSizes();
    ?>
    <style type="text/css">
        :root.html {
            <?php foreach ($themes as $themeKey => $theme) {
                foreach ($theme['colors'] as $colorName => $colorConfig) {
                    $colorValue = get_theme_mod("theme_{$themeKey}_color_{$colorName}", $colorConfig['default']);
                    $cssProperty = "--theme-{$themeKey}-color-{$colorName}";
                    echo "{$cssProperty}: {$colorValue};";

                    if ($colorConfig['hsl'] ?? false) {
                        $colorHsla = ColorHelpers::hexToHsla($colorValue);
                        echo "{$cssProperty}-h: {$colorHsla[0]};";
                        echo "{$cssProperty}-s: {$colorHsla[1]};";
                        echo "{$cssProperty}-l: {$colorHsla[2]};";
                    }
                }
            } ?>
            <?php foreach ($sizes as $sizeKey => $size) {
                $sizeValue = get_theme_mod("size_{$sizeKey}", $size['default']);
                echo "--{$sizeKey}: {$sizeValue}{$size['unit']};";
            } ?>
        }
    </style>
    <?php
}, 5);
