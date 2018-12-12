<?php

use Timber\Timber;
use Timber\Post;

$context = Timber::get_context();
$post = new Post();
$context['post'] = $post;
$context['feedTitle'] = $context['site']->name . ' ' . __('Feed', 'flynt-starter-theme');
$context['dir'] = is_rtl() ? 'rtl' : 'ltr';

Timber::render('twig/page.twig', $context);

// Flynt\echoHtmlFromConfig([
//     'name' => 'DocumentDefault',
//     'areas' => [
//         'layout' => [
//             [
//                 'name' => 'LayoutSinglePost',
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
//                             'name' => 'ComponentLoaderFlexible',
//                             'customData' => [
//                                 'fieldGroup' => 'postComponents'
//                             ]
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
