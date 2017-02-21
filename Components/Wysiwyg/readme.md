Title: Wysiwyg

----

Category: Block

----

Tags: wysiwyg, content, html, dom

----

Text: Content Editor.

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
  $toolbars['flynt'] = [];
  $toolbars['flynt'][1] = [
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

In this example, we create a new toolbar called `flynt`. You define which buttons show up. Then you need to specify that toolbar on your Wysiwyg field configuration (fields.json):

```json
{
  "name": "contentHTML",
  "label": "Content",
  "type": "wysiwyg",
  "media_upload": 0,
  "required": 1,
  "toolbar": "flynt"
}
```

### Editor Styles

You can also create new **styles**, globally by modifying the [TinyMce Feature](../../Features/TinyMce/README.md).

Unfortunately there is no way to have a stylesheet to a specific acf Wysiwyg field as it is possible for toolbars. So your stylesheet will be applied to all TinyMce instances.
