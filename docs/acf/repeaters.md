# Using Repeaters with ACF Pro

<div class="alert alert-info">
  <p><strong>To use repeater fields you must have purchased and installed the Advanced Custom Fields Pro plugin. <a href="https://www.advancedcustomfields.com/pro/">You can purchase this on the ACF website here.</a></strong></p>
</div>

The repeater field is a wrapper for a group of sub fields, so that mulitple rows of data of the same format can be easily looped over. [To see the full functionality of the repeater field in detail, read through the official ACF documentation on repeaters](https://www.advancedcustomfields.com/resources/repeater/).

To demonstrate, lets make a new component named `ImageTextList`.

Create `Components/ImageTextList/fields.json` and register a new repeater field:

```json
{
  "fields": [
    {
      "name": "items",
      "label": "Items",
      "type": "repeater",
      "button_label": "Add Item",
      "required": 1
    }
  ]
}
```

Now register two sub-fields for the repeater, `Image` and `Content`:

```json
{
  "fields": [
    {
      "name": "items",
      "label": "Items",
      "type": "repeater",
      "button_label": "Add Item",
      "required": 1,
      "sub_fields": [
        {
          "name": "image",
          "label": "Image",
          "type": "image",
          "mime_types": "jpg,jpeg",
          "required": 1
        },
        {
          "name": "content",
          "label": "Content",
          "type": "textarea",
          "new_lines": "wpautop",
          "required": 1
        }
      ]
    }
  ]
}
```

Add the component to the default `pageComponents` field group and check-out the repeater in the back-end. As you can see, the user is free to add and remove new rows as they wish - each containing an image and a content field.

Create `Components/ImageTextList/index.twig` and enter the following:

```twig
<div is="flynt-image-text-list">
  {% for item in items %}
    <div class="item">
      <img src="{{ item.image.src }}" alt="{{ item.image.alt }}">
      {{ item.content }}
    </div>
  {% endfor %}
</div>
```

Here we can loop through each entry within the repeater, outputting the same layout for each item. That's it! Repeaters provide a great, simple method for the user to add and display similar data again and again.
