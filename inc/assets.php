<?php

use Flynt\Utils\Asset;

add_action('wp_footer', function () {
    $scriptUrl = Asset::requireUrl('assets/main.js');
    $legacyScriptUrl = Asset::requireUrl('assets/main_legacy.js');
    echo "<script type=\"module\" src=\"{$scriptUrl}\"></script>";
    echo "<script nomodule src=\"{$legacyScriptUrl}\"></script>";
});

add_action('wp_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/icons',
        'type' => 'script',
        'path' =>
            'https://unpkg.com/feather-icons'
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/main.css',
        'type' => 'style'
    ]);
});

add_action('admin_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.js',
        'type' => 'script',
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.css',
        'type' => 'style'
    ]);
});

// Font Loading

add_action('wp_head', function () {
    echo getGoogleFontLinks('Montserrat:400,400i,700,700i');
});

function getGoogleFontLinks($family)
{
    return '<link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=' . $family . '" as="fetch" crossorigin="anonymous"> <script type="text/javascript"> !function(e,n,t){"use strict";var o="https://fonts.googleapis.com/css?family=' . $family . '",r="__3perf_googleFontsStylesheet";function c(e){(n.head||n.body).appendChild(e)}function a(){var e=n.createElement("link");e.href=o,e.rel="stylesheet",c(e)}function f(e){if(!n.getElementById(r)){var t=n.createElement("style");t.id=r,c(t)}n.getElementById(r).innerHTML=e}e.FontFace&&e.FontFace.prototype.hasOwnProperty("display")?(t[r]&&f(t[r]),fetch(o).then(function(e){return e.text()}).then(function(e){return e.replace(/@font-face {/g,"@font-face{font-display:swap;")}).then(function(e){return t[r]=e}).then(f).catch(a)):a()}(window,document,localStorage);
    </script>';
}
