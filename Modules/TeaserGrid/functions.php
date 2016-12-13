<?php
namespace Flynt\Modules\TeaserGrid;

use Flynt\DataFilters\MainQuery;
use Flynt\Helpers\Log;
use Flynt\Helpers\Utils;
use Flynt\Helpers\Module;

add_filter('Flynt/modifyModuleData?name=TeaserGrid', function ($data) {
  $data['teaserItems'] = array_map(function ($item) {

    if ($item['linkType'] == 'internalLink') {
      // $item['post'] = MainQuery::addAdditionalDefaultDataSinglePost($item['post']);
    }

    return $item;
  }, $data['teaserItems']);

  return $data;
});
