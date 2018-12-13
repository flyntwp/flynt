<?php

namespace Flynt\Features\ComponentLogServer;

use Flynt;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

add_action('Flynt/afterRegisterComponents', function () {
    $componentManager = Flynt\ComponentManager::getInstance();
    $componentWhitelist = [];
    if (isset($_GET['component']) && !empty($_GET['component'])) {
        $componentWhitelist = explode(',', $_GET['component']);
    }
    if (count($componentWhitelist) === 0) {
        foreach ($componentManager->getAll() as $name => $path) {
            add_filter("Flynt/addComponentData?name={$name}", NS . 'addDebugInfo', 12, 2);
        }
    } else {
        foreach ($componentManager->getAll() as $name => $path) {
            if (in_array($name, $componentWhitelist)) {
                add_filter("Flynt/addComponentData?name={$name}", NS . 'addDebugInfo', 12, 2);
            }
        }
    }
}, 11);

function addDebugInfo($data, $componentName)
{
    if ((WP_ENV === 'development' || current_user_can('editor') || current_user_can('administrator')) && isset($_GET['log'])) {
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

// add_action('init', function () {
//     // get all component names
//     $cm = Flynt\ComponentManager::getInstance();
//     $components = $cm->getAll();
//     $GLOBALS['logger'] = [];
//     $GLOBALS['loggerTotalDuration'] = 0;
//     foreach($components as $component => $path) {
//         // addComponent filter for all o' them
//         add_filter("Flynt/addComponentData?name={$component}", function ($data) use ($component) {
//             $now = microtime(true);
//             $GLOBALS['logger'][$component]['start'] = $now;
//             $data['logger'] = [
//                 'start' => $now
//             ];
//             return $data;
//         }, 1);
//         add_filter("Flynt/addComponentData?name={$component}", function ($data) use ($component) {
//             $now = microtime(true);
//             $duration = (float) sprintf('%.3f', $now - $data['logger']['start']);
//             $GLOBALS['logger'][$component]['end'] = $now;
//             $GLOBALS['logger'][$component]['duration'] = $duration;
//             $GLOBALS['loggerTotalDuration'] += $duration;
//             $data['logger']['end'] = $now;
//             $data['logger']['duration'] = $duration;
//             return $data;
//         }, 11);
//         // render filter for all
//         // add_filter("Flynt/renderComponent?name={$component}", function ($html) use ($component) {
//         //     $data['logger']['start'] = microtime(true);
//         //     return $data;
//         // }, 1);
//         // add_filter("Flynt/renderComponent?name={$component}", function ($html) use ($component) {
//         //     $data['logger']['end'] = microtime(true);
//         //     return $data;
//         // }, 11);
//     }
// }, 999);
