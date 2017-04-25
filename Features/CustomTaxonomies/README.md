# Custom Taxonomies (Flynt Feature)

Adds custom taxonomy functionality to Flynt. With this feature, you can simply use configuration files (json) to add custom taxonomies to your theme.

To use this feature simply put it into your `lib/Features` folder and initialize it in the `initTheme` function of your `lib/Init.php` like this:

```php
<?php

function initTheme() {
  ...

  add_theme_support('flynt-custom-taxonomies', [
    'dir' => get_template_directory() . '/config/customTaxonomies/'
  ]);

  ...
}

```

The second parameter passed is the folder where your custom taxonomy configs are going to be at. Feel free to adjust it according to your needs.

## Example
Now that you have initialized the feature, you can add a json file with the [configuration options as specified by Wordpress](https://codex.wordpress.org/Function_Reference/register_taxonomy#Parameters) to the folder specified above.

```json
{
  "label": "Genre",
  "description": "Some description",
  "show_ui": true,
  "show_admin_column": true,
  "objectType": "post",
  "labels": {
    "name": "Genres",
    "singular_name": "Genre",
    "search_items": "Search Genres",
    "all_items": "All Genres",
    "parent_item": "Parent Genre",
    "parent_item_colon": "Parent Genre:",
    "edit_item": "Edit Genre",
    "update_item": "Update Genre",
    "add_new_item": "Add New Genre",
    "new_item_name": "New Genre Name",
    "menu_name": "Genre"
  },
  "rewrite": {
    "slug": "genre",
    "with_front": false
  }
}
```
