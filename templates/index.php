<?php

use Timber\Timber;
use Timber\PostQuery;

$context = Timber::get_context();
$context['posts'] = new PostQuery();
// $context['foo'] = 'bar';
$templates = ['twig/index.twig'];
// if ( is_home() ) {
// 	array_unshift( $templates, 'front-page.twig', 'home.twig' );
// }
Timber::render($templates, $context);


// Flynt\echoHtmlFromConfig([
//     'name' => 'DocumentDefault',
//     'areas' => [
//         'layout' => [
//             [
//                 'name' => 'LayoutMultiplePosts',
//                 'areas' => [
//                     'mainHeader' => [
//                         [
//                             'name' => 'NavigationMain',
//                             'customData' => [
//                                 'menuSlug' => 'navigation_main'
//                             ]
//                         ]
//                     ],
//                     'pageComponents' => [
//                         [
//                             'name' => 'GridPosts'
//                         ]
//                     ],
//                     'mainFooter' => [
//                         [
//                             'name' => 'NavigationFooter',
//                             'customData' => [
//                                 'menuSlug' => 'navigation_footer'
//                             ]
//                         ],
//                         [
//                             'name' => 'BlockCookieNotice'
//                         ]
//                     ]
//                 ]
//             ]
//         ]
//     ]
// ]);
