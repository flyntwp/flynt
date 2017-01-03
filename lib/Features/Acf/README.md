# ACF (Flynt Feature)

## Requirements
- Advanced Custom Fields Plugin (preferably PRO)
- ACF Field Group Composer Plugin

## Content
### Loader
Checks for required plugins and initialises the helpers.

TIP: Add and activate the `AdminNotices` Feature before you activate the ACF Feature to enable a nice popup that shows you notifications in the admin panel for missing or inactive plugins.

### Helper: Field Group Composer
Requirements:
- Flynt Core
- Flynt Helper: Utils

Maps `fields.json` files in components to field groups in `config/fieldGroups` according to the predefined filter name:
```
Flynt/Components/<ComponentName>/<FieldArray>[/<OptionalFieldName>]
```

### Helper: Option Pages
Requirements:
- Flynt Helper: StringHelpers

Converts `option` key in `fields.json` files of components to acf option pages.

## Usage
Drag and drop the ACF Folder into your Flynt Theme's `lib/Features` directory. Make sure the folder name doesn't change! Then add the following code to the after_setup_theme hook in your `lib/init.php`:
```php
<?php

function initTheme() {

  ...

  add_theme_support('flynt-acf', [
    'FieldGroupComposer',
    'OptionPages'
  ]);
  
  ...
  
}
add_action('after_setup_theme', __NAMESPACE__ . '\\initTheme');

```

That's it! Now you can start adding `fields.json`s and field groups for ACF.
