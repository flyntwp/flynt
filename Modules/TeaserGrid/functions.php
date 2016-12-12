<?php
namespace Flynt\Theme\Modules\TeaserGrid;

use Flynt\Theme\DataFilters\MainQuery;
use Flynt\Theme\Helpers\Log;
use Flynt\Theme\Helpers\Utils;
use Flynt\Theme\Helpers\Module;

add_filter('Flynt/modifyModuleData?name=TeaserGrid', function ($data) {
  $data['teaserItems'] = array_map(function ($item) {

    if ($item['linkType'] == 'internalLink') {
      // $item['post'] = MainQuery::addAdditionalDefaultDataSinglePost($item['post']);
    }

    return $item;
  }, $data['teaserItems']);

  return $data;
});
