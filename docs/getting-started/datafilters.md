# 3. Using DataFilters

## Adding a DataFilter
Goal is to add "Gallery last updated on [x]".

In `config/templates/default.json`:
```php
{
  "name": "ImageSlider",
  "dataFilter": "Flynt/DataFilters/Gallery"
}
```

In `lib/DataFilters/Gallery.php`:
```php
add_filter('Flynt/DataFilters/Gallery', function($data) {
  $data['foo'] = 'bar';
  return $data;
});
```

- link to advanced: custom data.
- link to advanced: adding arguments to the data filter?

## Modifying Data in `functions.php`
