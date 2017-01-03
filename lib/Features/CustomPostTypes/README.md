# Custom Post Types (Flynt Feature)

Adds custom post type functionality to Flynt. With this feature, you can simply use configuration files (json) to add custom post types to your theme.

To use this feature simply put it into your `lib/Features` folder and initialize it in the `initTheme` function of your `lib/init.php` like this:

```php
<?php

function initTheme() {
  ...
  
  add_theme_support('flynt-custom-post-types', get_template_directory() . '/config/customPostTypes/');
  
  ...
}

```

The second parameter passed is the folder where your custom post type configs are going to be at. Feel free to adjust it according to your needs.

## Example
Now that you have initialized the feature, you can add a json file with the [configuration options as specified by Wordpress](https://codex.wordpress.org/Function_Reference/register_post_type#Parameters) to the folder specified above.

```json
{
  "name": "products",
  "label": "Product",
  "singular_label": "Product",
  "description": "Some description",
  "public": false,
  "show_ui": true,
  "show_in_nav_menus": false,
  "show_in_rest": false,
  "labels": {
    "menu_name": "Products",
    "all_items": "All products",
    "add_new": "Add new product"
  }
}
```
