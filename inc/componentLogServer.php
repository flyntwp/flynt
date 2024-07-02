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

add_action('Flynt/afterRegisterComponents', function (): void {
    if ('production' === wp_get_environment_type()) {
        return;
    }

    if (!isset($_GET['log'])) {
        return;
    }

    add_filter("Flynt/addComponentData", 'Flynt\ComponentLogServer\addDebugInfo', PHP_INT_MAX, 2);
}, PHP_INT_MAX);


function addDebugInfo(array $data, string $componentName): array
{
    $filterByComponents = [];
    if (isset($_GET['log']) && isset($_GET['component'])) {
        $filterByComponents = explode(',', $_GET['component']);
    }

    if (in_array($componentName, $filterByComponents) || $filterByComponents === []) {
        consoleDebug([
            'component' => $componentName,
            'data' => $data,
        ]);
    }

    return $data;
}

function consoleDebug(array $data): void
{
    $output = json_encode($data);
    $result =  "<script>console.log({$output});</script>\n";
    add_action('wp_footer', function () use ($result): void {
        echo $result;
    }, 30);
}
