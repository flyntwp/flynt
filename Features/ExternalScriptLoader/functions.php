<?php
namespace Flynt\Features\ExternalScriptLoader;

use Flynt\Utils\Asset;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

function enqueueComponentScripts()
{
    Asset::enqueue([
        'type' => 'script',
        'name' => 'Flynt/Features/ExternalScriptLoader',
        'path' => 'Features/ExternalScriptLoader/script.js'
    ]);
}

add_action('wp_enqueue_scripts', NS . 'enqueueComponentScripts');
