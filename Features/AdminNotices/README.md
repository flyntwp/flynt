# Admin Notices (Flynt Feature)

This Feature implements the `AdminNoticeManager` class.

## AdminNoticeManager

This class is to be used in other features to enable an easy-to-use interface for the display of admin notices.

### Example
```php
<?php

use Flynt\Features\AdminNotices\AdminNoticeManager;

// get the singleton instance of the manager
$manager = AdminNoticeManager::getInstance();

// Prepare the admin notice
$message = 'This notice will show up in the admin backend.';
$options = [
  'type' => 'info',
  'title' => 'Flynt Notice',
  'dismissible' => true,
  'filenames' => 'related-file.php, another.json'
];

// Add the notice to the admin backend
$manager->addNotice($message, $options);

// List all registered notices for debugging
var_dump($manager->getAll());

```
