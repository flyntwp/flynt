# Developer HowTo´s

### Editor Toolbar

The MCE Buttons that show up by default are specified in the **TinyMce Feature**, in the `mce_buttons` filter.

You can either modify that Feature to modify all the wysiwyg toolbars globally (all over your project), or define a specific configuration for one specific wysiwyg field, by using the `acf/fields/wysiwyg/toolbars` acf filter on your `functions.php` file.

#### To change the Toolbar globally on every TinyMce
Go to the [TinyMce Feature](../../Features/TinyMce/README.md).

#### To define a specific configuration for one specific Wysiwyg field
Go to the  component (`Wysiwyg` here) `functions.php` file, and use the `acf/fields/wysiwyg/toolbars` acf filter:

```php
<?php
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
  $toolbars['myCustomToolbar'] = [];
  $toolbars['myCustomToolbar'][1] = [
    'formatselect',
    'styleselect',
    'bold',
    'italic',
    'underline',
    'strikethrough',
    '|',
    'bullist',
    'numlist',
    '|',
    'outdent',
    'indent',
    'blockquote',
    'hr',
    '|',
    'alignleft',
    'aligncenter',
    'alignright',
    'alignjustify',
    '|',
    'link',
    'unlink',
    '|',
    'forecolor',
    'wp_more',
    'charmap',
    'spellchecker',
    'pastetext',
    'removeformat',
    '|',
    'undo',
    'redo',
    'wp_help',
    'fullscreen',
    'wp_adv', // toogle second bar button
  ];
  return $toolbars;
});
```

In this example, we create a new toolbar called `myCustomToolbar`. You define which buttons show up. Then you need to specify that toolbar on your Wysiwyg field configuration (fields.json):

```json
{
  "name": "contentHTML",
  "label": "Content",
  "type": "wysiwyg",
  "media_upload": 0,
  "required": 1,
  "toolbar": "myCustomToolbar"
}
```

### Editor Styles

You can also create new **styles**, globally by modifying the [TinyMce Feature](../../Features/TinyMce/README.md).

Unfortunately there is no way to have a stylesheet to a specific acf Wysiwyg field as it is possible for toolbars. So your stylesheet will be applied to all TinyMce instances.


## Snippets
### Default Theme

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
          "wysiwyg--fullwidth": "Fullwidth",
          "wysiwyg--narrow": "Narrow"
        },
        "default_value": ""
      }
    ]
  }
}
```

`index.twig`
```html
<div class="blockWysiwyg {{ theme }}"></div>
```

`style.styl`
```stylus
$containerMaxWidth = lookup('$globalContainerMaxWidth') || 1280px
$containerPadding = lookup('$globalContainerPadding') || 20px
$narrowWidth = 650px

[is='flynt-block-wysiwyg']
  .content
    center($containerMaxWidth, $containerPadding)

    &--fullwidth
      center($containerMaxWidth, $containerPadding)

    &--narrow
      center($narrowWidth, $containerPadding)
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
        "wysiwyg--fullwidth": "Fullwidth",
        "wysiwyg--narrow": "Narrow"
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
