<?php
namespace WPStarterTheme\Modules\TeaserGrid;

use WPStarterTheme\DataFilters\MainQuery;
use WPStarterTheme\Helpers\Log;
use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=TeaserGrid', function ($data) {

  $imageConfig = [
    'default' => 'large',
    'sizes' => [
      'thumbnail' => '(max-width: 767px)'
    ]
  ];

  $data['teaserItems'] = array_map(function ($item) use ($imageConfig) {
    switch ($item['linkType']) {
      case 'internalLink':
        $item['post'] = MainQuery::addAdditionalDefaultDataSinglePost($item['post']);
        $item['post']['post_thumbnail']['imageConfig'] = $imageConfig;
        break;
      case 'externalLink':
        $item['image']['imageConfig'] = $imageConfig;
        break;
    }

    return $item;

  }, $data['teaserItems']);

  return $data;
});
