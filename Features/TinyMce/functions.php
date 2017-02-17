<?php

namespace Flynt\Features\TinyMce;

// Clean Up TinyMCE Buttons

// First Bar
add_filter('mce_buttons', function ($buttons) {
  return [
    'formatselect',
    // 'styleselect',
    'bold',
    'italic',
    'underline',
    'strikethrough',
    '|',
    'bullist',
    'numlist',
    '|',
    // 'outdent',
    // 'indent',
    // 'blockquote',
    // 'hr',
    // '|',
    // 'alignleft',
    // 'aligncenter',
    // 'alignright',
    // 'alignjustify',
    // '|',
    'link',
    'unlink',
    '|',
    // 'forecolor',
    'wp_more',
    // 'charmap',
    // 'spellchecker',
    'pastetext',
    'removeformat',
    '|',
    'undo',
    'redo',
    // 'wp_help',
    'fullscreen',
    // 'wp_adv', // toggle visibility of 2 menu level
  ];
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
  return [];
});

add_filter('tiny_mce_before_init', function ($init) {
  // Add block format elements you want to show in dropdown
  $init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
  return $init;
});
