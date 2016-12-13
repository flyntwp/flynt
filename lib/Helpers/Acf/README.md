# ACF Helpers

## Requirements
- Advanced Custom Fields Plugin (preferably PRO)
- ACF Field Group Composer Plugin

## Content
### Loader
Checks for required plugins and initialises the helpers.

### Helper: Field Group Composer
Requirements:
- Flynt Core
- Flynt Helper: Utils

Maps `fields.json` files in modules to field groups in `config/fieldGroups` according to the predefined filter name:
```
Flynt/Modules/<ModuleName>/<FieldArray>[/<OptionalFieldName>]
```

### Helper: Option Pages
Requirements:
- Flynt Helper: StringHelpers

Converts `option` key in `fields.json` files of modules to acf option pages.

## Usage
Drag and drop your desired Helpers as well as the `Loader.php` into your Flynt Theme's `lib/Helpers/Acf` directory. Then add the following code to the `lib/init.php`:
```php
<?php

namespace Flynt\Init;

use Flynt\Helpers\Acf;

// initialize ACF Helpers
Acf\Loader::init([
  'FieldGroupComposer',
  'OptionPages'
]);

```

That's it! Now you can start adding `fields.json`s and field groups for ACF.
