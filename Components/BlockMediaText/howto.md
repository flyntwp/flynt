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
