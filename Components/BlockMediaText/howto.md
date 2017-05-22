# Developer HowTo´s

## Global Default Poster Image

`fields.json`
```json
{
  "globalOptions": [
    {
      "name": "defaultPosterImage",
      "label": "Default Poster Image",
      "type": "image",
      "mime_types": "jpg,jpeg",
      "instructions": "Image-Format: JPG"
    }
  ]
}
```

`functions.php`
```php
<?php
add_filter('Flynt/addComponentData?name=BlockMediaText', function ($data) {
    if ($data['mediaType'] === 'mediaVideo' && empty($data['posterImage'])) {
        $data['posterImage'] = $data['defaultPosterImage'];
    }
});
```

**Beware:** If you use this component as a static component (or any component with tabs), you need to add a closing tab*, otherwise the next components will show up inside the last tab.

*A tab with an empty label, and `"endpoint": 1`

```json
{
  "name": "endTab",
  "label": "",
  "type": "tab",
  "endpoint": 1
}
```
