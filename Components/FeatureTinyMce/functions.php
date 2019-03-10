<?php

namespace Flynt\Features\TinyMce;

use Flynt\Utils\Asset;

// Load TinyMCE Settings from config file

// First Toolbar
add_filter('mce_buttons', function ($buttons) {
    $config = getConfig();
    if ($config && isset($config['toolbars'])) {
        $toolbars = $config['toolbars'];
        if (isset($toolbars['default']) && isset($toolbars['default'][0])) {
            return $toolbars['default'][0];
        }
    }
    return $buttons;
});

// Second Toolbar
add_filter('mce_buttons_2', function ($buttons) {
    return [];
});

add_filter('tiny_mce_before_init', function ($init) {
    $config = getConfig();
    if ($config) {
        if (isset($config['blockformats'])) {
            $init['block_formats'] = getBlockFormats($config['blockformats']);
        }

        if (isset($config['styleformats'])) {
            // Send it to style_formats as true js array
            $init['style_formats'] = json_encode($config['styleformats']);
        }
    }
    return $init;
});

add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Load Toolbars and parse them into TinyMCE
    $config = getConfig();
    if ($config && !empty($config['toolbars'])) {
        $toolbars = array_map(function ($toolbar) {
            array_unshift($toolbar, []);
            return $toolbar;
        }, $config['toolbars']);
    }
    return $toolbars;
});

function getConfig()
{
    $filePath = Asset::requirePath('/Components/FeatureTinyMce/config.json');
    if (file_exists($filePath)) {
        return json_decode(file_get_contents($filePath), true);
    } else {
        return false;
    }
}

function getBlockFormats($blockFormats)
{
    if (!empty($blockFormats)) {
        $blockFormatStrings = array_map(function ($tag, $label) {
            return "${label}=${tag}";
        }, $blockFormats, array_keys($blockFormats));
        return implode($blockFormatStrings, ';');
    }
    return '';
}
