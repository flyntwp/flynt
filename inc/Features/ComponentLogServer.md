# HowTo

## Register Feature `/lib/init.php`
```php
<?php

function initTheme()
{
    add_theme_support('flynt-component-log-server');
}
```

## Usage
Add get param `log` to url e.g. `http://localhost:3000/?log` and all the data will be output to via console.log in the dev tools in the browser.
