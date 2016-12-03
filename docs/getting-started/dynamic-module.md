# 2. Adding dynamic content with Advanced Custom Fields (ACF)

This tutorial covers:
- [Adding Fields](#adding-fields)
- [Adding a Field Group](#adding-a-field-group)
- [Displaying Content with `$data()`](#displaying-content-with-data)
- [Adding a DataFilter](#adding-a-datafilter)
- [Modifying Data in `functions.php`](#modifying-data-in-functionsphp)

## Adding Fields
Create a `MediaSlider/fields.json` file and add the code below:

```json
{
  "layout": {
    "name": "MediaSlider",
    "label": "Media Slider",
    "sub_fields": [
      {
        "name": "title",
        "label": "Title",
        "type": "text"
      }
    ]
  }
}
```

The folder structure will now resemble the following:
```
- flynt-theme
| - Modules
  | - MediaSlider
    | - fields.json
    | - index.php.pug
```

- Extra: Add fields quicker using our acf-field-snippets. For atom + sublime text. Coming soon?!

## Adding a Field Group

## Displaying Content with `$data()`

## Adding a DataFilter
In `config/templates/default.json`:
```php
{
  "name": "MediaSlider",
  "dataFilter": "Flynt/DataFilters/MediaSliderFilter"
}
```

In `MediaSlider/functions.php`:
```php
add_filter('Flynt/DataFilters/MediaSliderFilter', function($data) {
  $data['foo'] = 'bar';
  return $data;
});
```

- link to advanced: custom data.
- link to advanced: adding arguments to the data filter?

## Modifying Data in `functions.php`
