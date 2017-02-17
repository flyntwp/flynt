# Snippets

## Global Default posterImage

`fields.json`
```json
{
  "options": [
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
`mixins/functions.php`

description on what you need to take care of

```php
add_filter('Flynt/addComponentData?name=Oembed', function ($data) {
  if (empty($data['posterImage'])) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }
});
```
