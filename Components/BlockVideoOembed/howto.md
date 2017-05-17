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
Don't forget to remove the `required: 1` option inside the `posterImage` field.

`functions.php`
```php
<?php
add_filter('Flynt/addComponentData?name=BlockVideoOembed', function ($data) {
    if (empty($data['posterImage'])) {
        $data['posterImage'] = $data['defaultPosterImage'];
    }
});
```
