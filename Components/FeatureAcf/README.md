# ACF (Flynt Feature)

## Requirements
- Advanced Custom Fields Plugin (preferably PRO)
- ACF Field Group Composer Plugin

## Content
### Loader
Checks for required plugins and initializes the helpers.

TIP: Add and activate the `AdminNotices` Feature to enable a nice popup that shows you notifications in the admin panel for missing or inactive plugins.

### Helper: Field Group Composer
Requirements:
- Flynt Core
- Flynt Utils: ArrayHelpers
- Flynt Utils: Feature
- Flynt Utils: FileLoader
- Flynt Utils: StringHelpers

Maps `fields.json` files in components to field groups in `config/fieldGroups` according to the predefined filter name:
```
Flynt/Components/<ComponentName>/Fields/<FieldArray>[/<OptionalFieldName>]
```

### Helper: Option Pages
Requirements:
- Flynt Helper: StringHelpers

Converts `globalOptions` key in `fields.json` files of components to acf option pages.

## Usage
Drag and drop the ACF Folder into your Flynt Theme's `Features` directory. Make sure the folder name doesn't change! Then add the following code to the after_setup_theme hook in your `lib/Init.php`:
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
