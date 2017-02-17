Title: Wysiwyg

----

Category: Block

----

Tags: Wysiwyg, content, HTML, DOM

----

Text: Content Editor.

### Editor Toolbar

The MCE Buttons that show up by default are specified in the **TinyMce Feature**, in the `mce_buttons` filter.

You can either modify that Feature to modify all the wysiwyg toolbars globally (all over your project), or define a specific configuration for one specific wysiwyg field, by using the `acf/fields/wysiwyg/toolbars` acf filter on your `functions.php` file.

#### To change the Toolbar globally on every TinyMce
Go to the **TinyMce Feature** `functions.php` file:

```php
// First Bar
add_filter('mce_buttons', function ($buttons) {
  return array(
    'undo', 'redo', '|',
    'bold', 'bullist', 'numlist', '|',
    'link', 'unlink', 'copy', 'paste', '|',
    'cleanup', 'removeformat', 'formatselect');
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
  return [];
});
```
Do your modifications there by adding/deleting the buttons you need.
You can also reactivate the second bar if needed.

#### To define a specific configuration for one specific Wysiwyg field
Go to the  component (`Wysiwyg` here) `functions.php` file, and use the `acf/fields/wysiwyg/toolbars` acf filter:

```php
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
  $toolbars['flynt'] = [];
  $toolbars['flynt'][1] = [
    'undo', 'redo', '|',
    'bold', 'bullist', 'numlist', '|',
    'link', 'unlink', 'copy', 'paste', '|'
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

You can also create new **styles**, globally by modifying the TinyMce Feature

Add styles globally on the **TinyMce Feature**, by adding the `styleselect` pulldown menu to the button list:

```php
add_filter('mce_buttons', function ($buttons) {
  return array(
    'undo', 'redo', '|',
    'bold', 'bullist', 'numlist', '|',
    'link', 'unlink', 'copy', 'paste', '|',
    'cleanup', 'removeformat', 'styleselect');
});
```

You need the `styleselect` in place to be able to register your own custom styles.
Once that it is done, use the `tiny_mce_before_init` filter to build your configuration parameters which you will inject your custom styles:

```php
add_filter('tiny_mce_before_init', function($init_array) {
  $style_formats = array(
    array(
      'title' => 'Highlight Text',
      'selector' => 'p',
      'classes' => 'primary-font'
    ),
    array(
      'title' => 'Brand Colour (Turquoise)',
      'inline' => 'span',
      'classes' => 'color-highlight'
    )
  );
  $init_array['style_formats'] = json_encode($style_formats);
  return $init_array;
});

```

Note that you can not add specific styles to one specific Wysiwyg acf field. Your styles will be applied to every TinyMce that has the `styleselect` pulldown menu available.


### Editor Stylesheet

You can link a custom stylesheet to the TinyMce editor with the `add_editor_style` function.

Go to the **TinyMce Feature** `functions.php` file:

```php
add_editor_style('Features/TinyMce/customEditorStyle.css');
```

Call the `add_editor_style` function and pass as a parameter your stylesheet file path (that we called `customEditorStyle.css` here).

Unfortunately there is no way to had a stylesheet to a specific acf Wysiwyg field as it is possible for toolbars. So your stylesheet will be applied to all TinyMce instances.
