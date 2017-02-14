# TinyMCE (Flynt Feature)

Cleans up TinyMCE Buttons to show all relevant buttons on the first bar.

### Editor Toolbar

The MCE Buttons that show up by default are specified by the `mce_buttons` filter in `functions.php` file.
You can modify that filter for all the Wysiwyg toolbars (all over your project).

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

NB: If you want to change the toolbar specifically to one Wysiwig acf field, check out the readme file of the Wysiwyg component for the instructions.

### Editor Styles

You can also create new **styles**, globally by modifying the TinyMce Feature, by adding the `styleselect` pulldown menu to the button list:

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

### Editor Stylesheet

You can link a custom stylesheet to the TinyMce editor with the `add_editor_style` function.

Go to the **TinyMce Feature** `functions.php` file:

```php
add_editor_style('Features/TinyMce/customEditorStyle.css');
```

Call the `add_editor_style` function and pass as a parameter your stylesheet file path (that we called `customEditorStyle.css` here). This file must be present inside this `TinyMce` feature.
