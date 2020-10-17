<?php

namespace Flynt\Components\FeatureAdminLoginBranding;

use Flynt\ComponentManager;
use Flynt\Utils\Asset;

add_action('login_enqueue_scripts', function () {
    $logo = [
        'src' => get_theme_mod('custom_header_logo') ? get_theme_mod('custom_header_logo') : Asset::requireUrl('Components/FeatureAdminLoginBranding/Assets/logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    $logoInlineCss = insertLogoInlineCss($logo['src']);
    echo $logoInlineCss;

    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.js',
        'type' => 'script',
        'inFooter' => false,
    ]);
    wp_script_add_data('Flynt/assets/admin', 'defer', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntData', $data);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.css',
        'type' => 'style'
    ]);
}, 99);

add_filter('login_headerurl', function () {
    return home_url();
});

add_filter('login_headertext', function () {
    return get_bloginfo('name') . ' – '. get_bloginfo('description');
});

function insertLogoInlineCss($logoUrl)
{
    return
        '<style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(' . $logoUrl . ');
        }
    </style>';
}
