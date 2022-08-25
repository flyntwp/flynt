<?php

/**
 * Usage:
 * Add get parameter `log` to url e.g. `http://localhost:3000/?log`
 * and all the data will be output via console.log in the dev tools
 * in the browser.
 *
 * Combine get parameter `log` with a second parameter `component` e.g.
 * `http://localhost:3000/?log&component=BlockWysiwyg` or
 * `http://localhost:3000/?log&component=BlockWysiwyg,BlockImage`
 * only the data for the specified component(s) will output via
 * console.log in the dev tools in the browser.
 */

namespace Flynt\ComponentLogServer;

use Flynt\Utils\Log;

add_action('Flynt/afterRegisterComponents', function () {
    if ('production' !== wp_get_environment_type() && isset($_GET['log'])) {
        add_filter("Flynt/addComponentData", __NAMESPACE__ . '\addDebugInfo', 99999, 2);
    }
}, 11);

function addDebugInfo($data, $componentName)
{
    $filterByComponents = [];
    if (isset($_GET['log']) && isset($_GET['component'])) {
        $filterByComponents = explode(',', $_GET['component']);
    }

    if (in_array($componentName, $filterByComponents) || empty($filterByComponents)) {
        Log::console([
            'component' => $componentName,
            'data' => $data,
        ]);
    }
    return $data;
}
