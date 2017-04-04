# Snippets

## Default Theme

`fields.json`
```json
{
  "layout": {
    "name": "blockWysiwyg",
    "label": "Block Wysiwyg",
    "sub_fields": [
      {
        "name": "settingsTab",
        "label": "Settings",
        "type": "tab"
      },
      {
        "name": "theme",
        "label": "Theme",
        "type": "select",
        "choices": {
          "": "---",
          "wysiwyg-fullwidth": "Fullwidth",
          "wysiwyg-narrow": "Narrow"
        },
        "default_value": ""
      }
    ]
  }
}
```

`index.twig`
```html
<div class="wysiwyg {{ theme }}">
```

`style.styl`
```stylus
$containerMaxWidth = lookup('$global-layout-containerMaxWidth') || 1140px
$narrowWidth = lookup('$global-layout-narrowWidth') || 650px

.wysiwyg
  center($containerMaxWidth, $gutterWidth)

  &-fullwidth
    center($containerMaxWidth, $gutterWidth)

  &-narrow
    center($narrowWidth, $gutterWidth)
```

## Additional Global Default Theme

To add an additional Global Default Theme simply add the following code to the Default Theme solution from above.

`fields.json`
```json
{
  "options": [
    {
      "name": "defaultTheme",
      "label": "Default Theme",
      "type": "select",
      "choices": {
        "": "---",
        "wysiwyg-fullwidth": "Fullwidth",
        "wysiwyg-narrow": "Narrow"
      },
      "default_value": ""
    }
  ]
}
```

`functions.php`
```php
<?php
add_filter('Flynt/addComponentData?name=BlockWysiwyg', function ($data) {
    if (empty($data['theme'])) {
        $data['theme'] = get_field('defaultTheme', 'options');
    }
    return $data;
});
```
