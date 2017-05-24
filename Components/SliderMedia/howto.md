# Developer HowTo´s

## Global Default Poster Image for Video Oembed

`fields.json`
```json
{
  "globalOptions": [
    {
      "name": "defaultPosterImage",
      "label": "Default Poster Image",
      "type": "image",
      "return_format": "array",
      "preview_size": "thumbnail",
      "min_width": 1440,
      "min_height": 720,
      "mime_types": "jpg,jpeg",
      "instructions": "Recommended Size: Min-Width 1440px; Min-Height: 720px; Image-Format: JPG"
    }
  ]
}
```

`functions.php`
```php
<?php
add_filter('Flynt/addComponentData?name=SliderMedia', function ($data) {
    if ($data['mediaType'] === 'mediaVideo' && empty($data['posterImage'])) {
        $data['posterImage'] = $data['defaultPosterImage'];
    }
    $data['mediaSlides'] = array_map(function ($item) {
        if ($item['mediaType'] == 'oembed') {
            if (empty($item['posterImage'])) {
                $item['image'] = $item['defaultPosterImage'];
            } else {
                $item['image'] = $item['posterImage'];
            }
        }
        return $item;
    }, $data['mediaSlides']);
});
```
