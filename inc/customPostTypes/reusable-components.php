<?php

namespace Flynt\CustomPostTypes;

function registerReusableComponentsPostType()
{
    $labels = [
        'name'                  => _x('Reusable Components', 'Component Post Type', 'flynt'),
        'singular_name'         => _x('Reusable Components', 'Component Post Type', 'flynt'),
        'menu_name'             => _x('Reusable Components', 'Component Post Type', 'flynt'),
        'name_admin_bar'        => __('Reusable Components', 'flynt'),
        'archives'              => __('Reusable Component Archives', 'flynt'),
        'attributes'            => __('Reusable Component Attributes', 'flynt'),
        'parent_item_colon'     => __('Parent Reusable Component:', 'flynt'),
        'all_items'             => __('All Reusable Components', 'flynt'),
        'add_new_item'          => __('Add New Reusable Components', 'flynt'),
        'new_item'              => __('New Reusable Components', 'flynt'),
        'edit_item'             => __('Edit Reusable Components', 'flynt'),
        'update_item'           => __('Update Reusable Components', 'flynt'),
        'view_item'             => __('View Reusable Components', 'flynt'),
        'view_items'            => __('View Reusable Components', 'flynt'),
        'search_items'          => __('Search Reusable Components', 'flynt'),
        'not_found'             => __('No reusable components found', 'flynt'),
        'not_found_in_trash'    => __('No reusable components found in Trash', 'flynt'),
        'items_list'            => __('Reusable components list', 'flynt'),
        'items_list_navigation' => __('Reusable components list navigation', 'flynt'),
        'filter_items_list'     => __('Filter reusable components list', 'flynt'),
    ];
    $args = [
        'labels'                => $labels,
        'supports'              => ['title', 'revisions'],
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-controls-repeat',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'capability_type'       => 'page',
        'rewrite'               => false
    ];
    register_post_type('reusable-components', $args);
}

add_action('init', '\\Flynt\\CustomPostTypes\\registerReusableComponentsPostType');
