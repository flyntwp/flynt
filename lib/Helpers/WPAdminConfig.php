<?php

namespace WPStarterTheme\Helpers;

use WP_User;
use WPStarterTheme\Config;

class WPAdminConfig {
  public static function getConfig() {
    $configPath = json_decode(file_get_contents(Config\CONFIG_PATH . 'wordpress/admin.json'));
    return $configPath;
  }

  public static function removePages() {
    $config     = self::getConfig();
    $pageConfig = $config->pages;
    $userRoles  = self::getCurrentUserRole();

    foreach ($pageConfig as $ruleset) {
      # Remove pages set for current role if found.
      if (isset($ruleset->roles)) {
        $roleRules = Helper\objectToArray($ruleset->roles);
        foreach ($roleRules as $targetRole => $pages) {
          if (in_array($targetRole, $userRoles)) {
            foreach ($pages as $page) {
              self::removePage($page);
            }
          }
        }
        unset($ruleset->roles);
      }

      # Remove global page rules.
      $ruleset = Helper\objectToArray($ruleset);
      self::removePage($ruleset);
    }

  }

  public static function getCurrentUserRole() {
    $user = new WP_User(get_current_user_id());
    if (!empty($user->roles) && is_array($user->roles)) {
      return $user->roles;
    }
  }

  public static function removePage($page) {
    if (is_array($page)) {
      foreach ($page as $name => $type) {
        if ($name == 'post_type') {
          foreach ($type as $slug) {
            remove_menu_page('edit.php?'.$name.'=' . $slug);
          }
        } else {
          foreach ($type as $slug) {
            remove_menu_page($name . '?page=' . $slug);
          }
        }

      }
    } else {
      remove_menu_page($page);
    }
  }

  public static function removeWidgets() {
    $config       = self::getConfig();
    $widgetConfig = $config->widgets;
    $userRoles    = self::getCurrentUserRole();

    $toRemove = [];

    foreach ($widgetConfig as $ruleset) {
      if (isset($ruleset->roles)) {
        $roles = Helper\objectToArray($ruleset->roles);
        foreach ($roles as $role => $widget) {
          if (in_array($role, $userRoles)) {
            self::removeWidget($widget[0]);
          }
        }
        unset($ruleset->roles);
      }

      self::removeWidget($ruleset);
    }
  }

  public static function removeWidget($rules) {
    $ruleset = Helper\objectToArray($rules);
    foreach ($ruleset as $location => $type) {
      foreach ($type as $slug) {
        remove_meta_box($slug, $location, 'normal');
        remove_meta_box($slug, $location, 'advanced');
        remove_meta_box($slug, $location, 'side');
      }
    }
  }

  public static function removeAdminBarNodes($wpAdminBar) {
    $config = self::getConfig();
    $nodes = $config->adminBar;
    $userRoles = self::getCurrentUserRole();

    foreach ($nodes as $node) {
      if (isset($node->roles)) {
        foreach ($node->roles as $ruleset) {
          $ruleset = Helper\objectToArray($ruleset);
          foreach ($ruleset as $userRole => $userNodes) {
            if (in_array($userRole, $userRoles)) {
              foreach ($userNodes as $n) {
                $wpAdminBar->remove_node($n);
              }
            }
          }
        }
      } else {
        $wpAdminBar->remove_node($node);
      }
    }
  }
}
