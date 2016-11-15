<?php

namespace WPStarterTheme\Helpers;

use WPStarterTheme\Helpers\StringHelpers;

class Navigation {
  public static function getMenuLinks($menu_name) {
    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
      $menu = wp_get_nav_menu_object($locations[$menu_name]);
      $menu_items = wp_get_nav_menu_items($menu->term_id, array('orderby' => 'menu_order'));
      self::setActiveStates($menu_items);
      $menu_links = self::formatMenuItems($menu_items);
      $menu_links = self::convertToTree($menu_links);

      return $menu_links;
    }
  }

  private static function setActiveStates(&$menu_items) {
    if ($current_object = get_queried_object()) {
      $current_id = isset($current_object->ID) ? $current_object->ID : $current_object->term_id;

      foreach ($menu_items as &$menu_item) {
        if ($menu_item->object == 'custom') {
          $current_url = strtok($_SERVER["REQUEST_URI"],'?');
          if (StringHelpers::strstartswith($current_url, $menu_item->url)) {
            array_push($menu_item->classes, 'active');
          }
        } else {
          $isSameType = isset($current_object->post_type) ? ($menu_item->object == $current_object->post_type) : ($menu_item->object == $current_object->taxonomy);

          if ($menu_item->object_id == $current_id && $isSameType) {
            array_push($menu_item->classes, 'active');
            self::setParentActiveStates($menu_items, $menu_item->menu_item_parent);
          }
        }
      }
    }
  }

  private static function setParentActiveStates(&$menu_items, $active_menu_item_parent_id) {
    foreach ($menu_items as &$menu_item) {
      if ($menu_item->ID == $active_menu_item_parent_id) {
        array_push($menu_item->classes, 'active');
        self::setParentActiveStates($menu_items, $menu_item->menu_item_parent);
      }
    }
  }

  private static function formatMenuItems($menu_items) {
    $menu_links = array();

    foreach ($menu_items as $menu_item) {
      $current_url = $_SERVER['REQUEST_URI'];
      $body_class = get_body_class();
      $id = $menu_item->ID;
      $title = $menu_item->title;
      $url = $menu_item->url;
      $target = $menu_item->target;
      $current_page_class = '';
      $menu_url = parse_url($menu_item->url);

      $css_classes_array = $menu_item->classes;
      $css_classes_array[] = $current_page_class;
      $css_classes = join(' ', $css_classes_array);

      $menu_links[$id] = array(
        'id' => $id,
        'title' => $title,
        'href' => $url,
        'text' => $title,
        'target' => $target,
        'current_page_class' => $current_page_class,
        'menu_url' => $menu_url,
        'css_classes' => $css_classes,
        'menu_item_parent' => $menu_item->menu_item_parent
      );
    }

    return $menu_links;
  }

  private static function convertToTree(array $flat, $idField = 'id', $parentIdField = 'menu_item_parent', $childNodesField = 'links') {
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

    return $indexed[0][$childNodesField];
  }

}
