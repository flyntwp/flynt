<?php

namespace Flynt\Theme\Helpers;

use Flynt\Theme\Helpers\StringHelpers;

class Navigation {
  public static function getMenuLinks($locationName) {
    if (($locations = get_nav_menu_locations()) && isset($locations[$locationName])) {
      $menu = wp_get_nav_menu_object($locations[$locationName]);
      if (!$menu) {
        trigger_error('You did not assign any menu to the location: ' . $locationName, E_USER_WARNING);
        return [];
      }
      // @codingStandardsIgnoreLine
      $menuItems = wp_get_nav_menu_items($menu->term_id, array('orderby' => 'menu_order'));
      self::setActiveStates($menuItems);
      $menuLinks = self::formatMenuItems($menuItems);
      $menuLinks = self::convertToTree($menuLinks);

      return $menuLinks;
    }
  }

  private static function setActiveStates(&$menuItems) {
    if ($currentObject = get_queried_object()) {
      // @codingStandardsIgnoreLine
      $currentId = isset($currentObject->ID) ? $currentObject->ID : $currentObject->term_id;

      foreach ($menuItems as &$menuItem) {
        if ($menuItem->object == 'custom') {
          $currentUrl = strtok($_SERVER["REQUEST_URI"], '?');

          if (StringHelpers::strstartswith($currentUrl, $menuItem->url)) {
            array_push($menuItem->classes, 'active');
          }
        } else {
          // @codingStandardsIgnoreStart
          if (isset($currentObject->post_type)) {
            $isSameType = $menuItem->object == $currentObject->post_type;
          } else {
            $isSameType = $menuItem->object == $currentObject->taxonomy;
          }
          // @codingStandardsIgnoreEnd

          // @codingStandardsIgnoreStart
          if ($menuItem->object_id == $currentId && $isSameType) {
            array_push($menuItem->classes, 'active');
            self::setParentActiveStates($menuItems, $menuItem->menu_item_parent);
          }
          // @codingStandardsIgnoreEnd
        }
      }
    }
  }

  private static function setParentActiveStates(&$menuItems, $activeMenuItemParentId) {
    foreach ($menuItems as &$menuItem) {
      if ($menuItem->ID == $activeMenuItemParentId) {
        array_push($menuItem->classes, 'active');
        // @codingStandardsIgnoreLine
        self::setParentActiveStates($menuItems, $menuItem->menu_item_parent);
      }
    }
  }

  private static function formatMenuItems($menuItems) {
    $menuLinks = array();

    foreach ($menuItems as $menuItem) {
      $currentUrl = $_SERVER['REQUEST_URI'];
      $id = $menuItem->ID;
      $title = $menuItem->title;
      $url = $menuItem->url;
      $target = $menuItem->target;
      $currentPageClass = '';
      $menuUrl = parse_url($menuItem->url);

      $cssClassesArray = $menuItem->classes;
      $cssClassesArray[] = $currentPageClass;
      $cssClasses = join(' ', $cssClassesArray);

      $menuLinks[$id] = array(
        'id' => $id,
        'title' => $title,
        'href' => $url,
        'text' => $title,
        'target' => $target,
        'current_page_class' => $currentPageClass,
        'menu_url' => $menuUrl,
        'css_classes' => $cssClasses,
        // @codingStandardsIgnoreLine
        'menu_item_parent' => $menuItem->menu_item_parent
      );
    }

    return $menuLinks;
  }

  private static function convertToTree(
    array $flat,
    $idField = 'id',
    $parentIdField = 'menu_item_parent',
    $childNodesField = 'links'
  ) {

    $indexed = array();

    // first pass - get the array indexed by the primary id
    foreach ($flat as $row) {
      $indexed[$row[$idField]] = $row;
      $indexed[$row[$idField]][$childNodesField] = array();
    }

    // second pass
    foreach ($indexed as $id => $row) {
      $indexed[$row[$parentIdField]][$childNodesField][$id] =& $indexed[$id];
    }
    if (isset($indexed[0]))
      return $indexed[0][$childNodesField];

    return $indexed;
  }

}
