<?php
namespace WPStarterTheme\Modules\TeaserGrid;

use WPStarterTheme\DataFilters\MainQuery;
use WPStarterTheme\Helpers\Log;
use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=TeaserGrid', function ($data) {
  $data['teaserItems'] = array_map(function ($item) {

    if ($item['linkType'] == 'internalLink') {
      // $item['post'] = MainQuery::addAdditionalDefaultDataSinglePost($item['post']);
    }

    return $item;
  }, $data['teaserItems']);

  return $data;
});
