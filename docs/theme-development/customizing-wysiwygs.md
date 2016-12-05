# Customizing Module WYSIWYGs

In module `functions.php` file:

```php
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
  $toolbars['bleech'] = [];
  $toolbars['bleech'][1] = array(
    'undo', 'redo', 'styleselect', '|',
    'cleanup', 'removeformat', 'formatselect');
  return $toolbars;
});
```

In module `fields.json` for the target wysiwyg:

```json
{
  "name": "contentHTML",
  "label": "Content",
  "type": "wysiwyg",
  "toolbar": "bleech",
  "media_upload": 0,
  "required": 1
}
```
