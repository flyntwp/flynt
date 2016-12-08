# 3. Adding & Displaying ACF Fields

<div class="alert alert-info">
  <strong>A requirement of this tutorial is using the Wordpress Plugin <a href="https://www.advancedcustomfields.com/">Advanced Custom Fields (ACF)</a>. Please make sure this is installed and enabled before continuing.</strong>
</div>

<div class="alert">
  <h3>This tutorial covers:</h3>
  <ul>
    <li><strong><a href="#31-adding-acf-fields">3.1 Adding ACF Fields</a></strong></li>
    <li><strong><a href="#32-adding-a-field-group">3.2 Adding a Field Group</a></strong></li>
    <li><strong><a href="#33-displaying-content-with-data">3.3 Displaying Content with <code>$data()</code></a></strong></li>
    <li><strong><a href="#34-understanding-the-flynt-data-flow">3.4 Understanding the Flynt Data Flow</a></strong></li>
    <li><strong><a href="#35-taking-our-module-further">3.5 Taking our Module Further</a></strong></li>
  </ul>
</div>

## 3.1 Adding ACF Fields
To get started, we will add a simple ACF text field. Create `Modules/ImageSlider/fields.json` and add the code below to it:

```json
{
  "fields": [
    {
      "name": "title",
      "label": "Title",
      "type": "text",
      "required": 1
    }
  ]
}
```

The folder structure will now resemble the following:

```
flynt-theme/
├── Modules/
   └── ImagesSlider/
       └── index.php.pug
       └── fields.json
```

That's all we need to do to register a new field.

This functionality is driven by the Advanced Custom Fields (ACF) Wordpress plugin, and there are many other field types available. Flynt supports all of the field types provided by ACF, as well as all of the default field options as provided by the plugin.

To see the full list of available fields and their available options, check out the [official ACF documentation here](https://www.advancedcustomfields.com/resources/#field-types).

<!-- - Extra: Add fields quicker using our acf-field-snippets. For atom + sublime text. Coming soon?! -->

Before we can use these fields to add content, we first need to let Flynt know in which situations these fields should be available to the editor in the backend.

## 3.2 Adding a Field Group

All field group configuration files can be found in the `config/fieldGroups` directory. For this tutorial we will modify the default `pageModules` configuration.

Open `config/fieldGroups/pageModules.json` and replace the contents with the following:

```json
{
  "name": "pageModules",
  "title": "Page Modules",
  "fields": [
    "Flynt/Modules/ImageSlider/Fields"
  ],
  "location": [
    [
      {
        "param": "post_type",
        "operator": "==",
        "value": "page"
      }
    ]
  ]
}
```

<!-- TODO: explain the fields/modules/imageslider/fields line.  -->

Here we are setting the location where the field group should be displayed to the "Page" post type.

As with the field settings, we are writing our location rules using the configuration options provided by Advanced Custom Fields. To read more about this, check out the [official ACF documentation on location rules](https://www.advancedcustomfields.com/resources/custom-location-rules/).

That's it! Navigate to the backend of your Wordpress installation and create a new page. At the bottom, you'll now see a new section for your Image Slider module with a field labeled "Title".

![Title Field Screenshot](../assets/first-module-field.png)

Add "Our Image Gallery" into the title text field and save the page. Next, we'll move on to displaying this content on the front-end.

## 3.3 Displaying Content with `$data()`
Open up the `Modules/ImageSlider/index.php.pug` we made in the previous section.

We can now display the title using the `$data()` function. This function takes the name of your field as a parameter and returns the value.

```jade
div(is='flynt-image-slider')
  .slider
    h1.slider-title= $data('title')
```

<p><a href="/" class="source-note">See the source for <code>$data</code> in the Flynt Core plugin documentation.</a></p>

## 3.4 Understanding the Flynt Data Flow

At this point it is important to understand how the Flynt Core plugin is passing this data to the view. In actual fact, the data function uses the data passed to the template referenced by its keys. This can be understood much easier with the flowchart below:

<pre class="language- flowchart">
  <code>
  +------------------------------+
  |    Template Configuration    |
  +--------------+---------------+
                 |
                 |
  +--------------v---------------+
  |         DataFilters          |
  +--------------+---------------+
                 |
                 |
  +--------------v---------------+
  |       modifyModuleData       |
  +--------------+---------------+
                 |
       Pass $data to template
                 |
  +--------------v---------------+
  |        Rendered HTML         |
  +------------------------------+
  </code>
</pre>

<!-- <pre class="language- flowchart">
  <code>
  +------------------------------+
  |    Template Configuration    |
  +--------------+---------------+
                 |
                 |
  +--------------v---------------+
  |         Parent Data          |
  +--------------+---------------+
                 |
                 |
  +--------------v---------------+
  |    Initial Module Config     |
  +--------------+---------------+
                 |
                 |
  +--------------v---------------+
  |         DataFilters          |
  +--------------+---------------+
                 |
                 |
  +--------------v---------------+
  |         Custom Data          |
  +--------------+---------------+
                 |
                 |
  +--------------v---------------+
  |       modifyModuleData       |
  +--------------+---------------+
                 |
       Pass data to template
                 |
  +--------------v---------------+
  |        Rendered HTML         |
  +------------------------------+
  </code>
</pre> -->

<a href="/add-link" class="source-note">To dig into this more, read through the full flowchart in the Flynt Core plugin documentation.</a>

## 3.5 Taking our Module Further
Since we are making an image slider, let's use `field.json` to add a gallery field to our module:

```json
{
  "fields": [
    {
      "name": "title",
      "label": "Title",
      "type": "text",
      "required": 1
    },
    {
      "name": "images",
      "label": "Images",
      "type": "gallery",
      "mime_types": "jpg, jpeg",
      "required": 1
    },
  ]
}
```

Open up your page in the backend and you will now see our new gallery field, with the label "Images". Add some sample images to the field and save your page.

For ease, we have prepared some images that you can [download here](/add-link). (Source: [Unsplash](https://unsplash.com))

In `Modules/ImageSlider/index.php.pug`, we can now loop over our images using the `$data` function:

```jade
div(is='flynt-image-slider')
  .slider
    h1.slider-title= $data('title')
    .slider-items
      for image in $data('images')
        .slider-item
          img(src=$data(image, 'url'))
```

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>We now have a simple module that takes data from our fields and outputs them on the front-end! But what if we want do pull other data in our module? The next section explores passing additional data to our module using DataFilters.</p>

  <p><a href="datafilters.md" class="btn btn-primary">Go to Section 4</a></p>
</div>
