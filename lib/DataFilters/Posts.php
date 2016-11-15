<?php

use WPStarterTheme\Helpers;

add_filter('WPStarterTheme/DataFilters/Posts', function($data, $parentData, $postsPerPage, $contentType) {
  $posts = [
    [
      'title' => 'Post 1',
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
      'image' => 'http://crossfitbentonville.com/wp-content/uploads/2014/09/Rest-Day-Cat-400x150.jpg'
    ],
    [
      'title' => 'Post 2',
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
      'image' => 'http://i.imgur.com/4xl2zEI.png'
    ],
    [
      'title' => 'Post 3',
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
      'image' => 'http://orig11.deviantart.net/0914/f/2012/047/b/7/cat_signature_by_korakina-d4px6vs.jpg'
    ],
    [
      'title' => 'Post 4',
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
      'image' => 'http://2.bp.blogspot.com/_GSBoGQa_9BE/SS37pYD1yVI/AAAAAAAAChY/bdTXWXnz31I/s400/tummy.jpg'
    ],
    [
      'title' => 'Post 5',
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
      'image' => 'http://lazypenguins.com/wp-content/uploads/wordpress-popular-posts/2717-featured-400x150.jpg'
    ]
  ];

  if($contentType === "short") {
    $posts = array_map(function($data) {
      $data['content'] = Helpers\StringHelpers::trimStrip($data['content']);
      return $data;
    }, $posts);
  }

  if(count($posts) > $postsPerPage) {
    $posts = array_slice($posts, 0, $postsPerPage);
  }

  return [
    'parentData' => $parentData,
    'title' => 'Teaser',
    'posts' => $posts
  ];
}, 10, 4);
