<?php

WPStarter\echoHtmlFromConfigFile('page.json');

// render the index.php of your simple module
// WPStarter\echoHtmlFromConfig([
//   'name' => 'sampleLayout',
//   'areas' => [
//     'mainTemplate' => [
//       [
//         'name' => 'sampleTemplate',
//         'areas' => [
//           'mainHeader' => [
//             [
//               'name' => 'sampleModule1',
//               'dataFilter' => 'WPStarterTheme/MainHeader'
//             ]
//           ],
//           'mainContent' => [
//             [
//               'name' => 'sampleModule1',
//               'dataFilter' => 'WPStarterTheme/MainHeader',
//               'customData' => [
//                 'text' => 'sampleModule1 - Custom Data Filter'
//               ]
//             ],
//             [
//               'name' => 'sampleModule2',
//               'dataFilter' => 'WPStarterTheme/Posts'
//             ]
//           ]
//         ]
//       ]
//     ]
//   ]
// ]);

// $json_indented_by_4 = json_encode([
//   'name' => 'sampleLayout',
//   'areas' => [
//     'mainTemplate' => [
//       [
//         'name' => 'sampleTemplate',
//         'areas' => [
//           'mainHeader' => [
//             [
//               'name' => 'sampleModule1',
//               'dataFilter' => 'WPStarterTheme/MainHeader'
//             ]
//           ],
//           'mainContent' => [
//             [
//               'name' => 'sampleModule1',
//               'dataFilter' => 'WPStarterTheme/MainHeader',
//               'customData' => [
//                 'text' => 'sampleModule1 - Custom Data Filter'
//               ]
//             ],
//             [
//               'name' => 'sampleModule2',
//               'dataFilter' => 'WPStarterTheme/Posts'
//             ]
//           ]
//         ]
//       ]
//     ]
//   ]
// ], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
// $json_indented_by_2 = preg_replace('/^(  +?)\\1(?=[^ ])/m', '$1', $json_indented_by_4);
// echo $json_indented_by_2;
