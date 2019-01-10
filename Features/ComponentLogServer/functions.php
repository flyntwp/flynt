<?php

namespace Flynt\Features\ComponentLogServer;

use Flynt;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

add_action('Flynt/afterRegisterComponents', function () {
    if ((WP_ENV === 'development' || current_user_can('editor') || current_user_can('administrator')) && isset($_GET['log'])) {
        if (isset($_GET['component']) && !empty($_GET['component'])) {
            define(__NAMESPACE__ . '\COMPONENT_WHITELIST', explode(',', $_GET['component']));
        }
        add_filter("Flynt/addComponentData", NS . 'addDebugInfo', 99999, 2);
    }
}, 11);

function addDebugInfo($data, $componentName)
{
    if (!defined(__NAMESPACE__ . '\COMPONENT_WHITELIST') ||
        in_array($componentName, Flynt\Features\ComponentLogServer\COMPONENT_WHITELIST)
    ) {
        consoleDebug([
            'component' => $componentName,
            'data' => $data,
        ]);
    }
    return $data;
}

function consoleDebug($data, $postpone = true)
{
    $type = gettype($data);
    $output = json_encode($data);
    $result =  "<script>console.log({$output});</script>\n";
    echoDebug($result, $postpone);
}

function consoleTable($data, $postpone = true)
{
    $output = json_encode($data);
    $result =  "<script>console.table({$output});</script>\n";
    echoDebug($result, $postpone);
}

function echoDebug($data, $postpone)
{
    if ($postpone) {
        add_action('wp_footer', function () use ($data) {
            echo $data;
        }, 30);
    } else {
        echo $data;
    }
}
