# 3. Adding & Displaying ACF Fields

<div class="alert alert-info">
  <strong>A requirement of this tutorial is using the Wordpress Plugin <a href="https://www.advancedcustomfields.com/">Advanced Custom Fields (ACF)</a>. Please make sure this is installed and enabled before continuing.</strong>
</div>

<div class="alert">
  <h3>This tutorial covers:</h3>
  <ul>
    <li><strong><a href="#31-adding-acf-fields">3.1 Adding ACF Fields</a></strong></li>
    <li><strong><a href="#32-adding-a-field-group">3.2 Adding a Field Group</a></strong></li>
    <li><strong><a href="#33-displaying-field-content">3.3 Displaying Field Content</a></strong></li>
    <li><strong><a href="#34-understanding-the-flynt-data-flow">3.4 Understanding the Flynt Data Flow</a></strong></li>
    <li><strong><a href="#35-taking-our-component-further">3.5 Taking our Component Further</a></strong></li>
  </ul>
</div>

## 3.1 Adding ACF Fields
Advanced Custom Fields (ACF) is a Wordpress plugin to make adding custom meta fields easy and intuitive, with a straight-forward API and seamless integration into the back-end of Wordpress. With Flynt, we use ACF to add user-editable fields on a component level.

To get started, we will add a single ACF text field to the `PostSlider` component.

Create `Components/PostSlider/fields.json` and add the code below to it:

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
└── Components/
   └── PostSlider/
       └── index.twig
       └── fields.json
```

That's all we need to do to configure a new field! But before we can use these fields to add content, we need to define in which situations these fields should be available to the editor in the backend. We will do this in the next section by adding a new "Field Group".

<a href="https://github.com/bleech/wp-starter-snippets" class="source-note source-note--info">ACF offers around 20 different field types. To make the process of authoring these fields simpler, install our field.json snippets for Atom or Sublime Text.</a>

<div class="alert">
  <p>You can see the full list of available fields and their options in the <strong><a href="https://www.advancedcustomfields.com/resources/#field-types">official ACF documentation</a></strong>.</p>

  <p>We also have documentation on how best to use several of the ACF Pro field types with Flynt:</p>

  <br>

  <ul>
    <li><strong><a href="../theme-development/advanced/flexible-content.md">Using the ACF Pro "Flexible Content" Field</a></strong></li>
    <li><strong><a href="../theme-development/advanced/repeaters.md">Using the ACF Pro "Repeater" Field</a></strong></li>
    <li><strong><a href="../theme-development/advanced/options-pages.md">Using the ACF Pro "Options" Page</a></strong></li>
  </ul>
</div>

## 3.2 Adding a Field Group

All field group configuration files can be found in the `config/fieldGroups` directory. For this tutorial we will modify the default `pageComponents` configuration.

Open `config/fieldGroups/pageComponents.json` and replace the contents with the following:

```json
{
  "name": "pageComponents",
  "title": "Page Components",
  "fields": [
    "Flynt/Components/PostSlider/Fields"
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

In the "fields" array, we specifically pull in the fields from our Post Slider component. If we also had more components, we could also pull these into our Page Components group. For example:

```json
{
  "name": "pageComponents",
  "title": "Page Components",
  "fields": [
    "Flynt/Components/PostSlider/Fields"
    "Flynt/Components/ExampleComponent/Fields",
    "Flynt/Components/AnotherComponent/Fields",
  ]
}
```

Below this, we are also setting the location where the field group should be displayed to the "Page" post type.

```json
"location": [
  [
    {
      "param": "post_type",
      "operator": "==",
      "value": "page"
    }
  ]
]
```

<a class="source-note source-note--info" href="https://www.advancedcustomfields.com/resources/custom-location-rules/">
As with the field settings, we are writing our location rules using the same configuration options as Advanced Custom Fields. We strongly recommend reading more about these rules in the official ACF documentation</a>.

That's it! Navigate to the backend of Wordpress and create a new page. At the bottom, you'll now see a section for your Post Slider component with a field labeled "Title".

Add "Our Featured Posts" into the title text field and save the page. Next, we'll move on to displaying this content on the front-end.

## 3.3 Displaying Field Content
We can now display the title in our front-end [Twig](twig.sensiolabs.org) template.

Open `Components/PostSlider/index.twig` and update it with the following code:

```twig
<div is="flynt-post-slider">
  <div class="slider">
    <h1 class="slider-title">{{ title }}</h1>
  </div>
</div>
```

Since all of the fields configured in the component are automatically available in the view, this is all there is to it!

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
  |      modifyComponentData     |
  +--------------+---------------+
                 |
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
  |    Initial Component Config  |
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
  |       modifyComponentData    |
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

## 3.5 Taking our Component Further
We will now create an image slider by pulling the featured image from a list of posts selected by the user.

Open `Modules/PostSlider/field.json` and add a post object field to our component:

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
      "name": "posts",
      "label": "Posts",
      "type": "post_object",
      "post_type": ["post"],
      "return_format": "object",
      "multiple": 1,
      "required": 1
    }
  ]
}
```

To continue, create a few dummy posts and add a featured image to each one. You can grab some sample images from [Unsplash](https://unsplash.com).

Now open up your page in the backend and you will now see our new field, with the label "Posts". Select your dummy posts and save the page.

<!-- TODO: Add screenshot. -->

In `Components/PostSlider/index.twig`, we can now loop through our posts and output the title and featured image for each one:

```twig
<div is="flynt-post-slider">
  <div class="slider">
    <h1 class="slider-title">{{ title }}</h1>
    <div class="slider-items">
      {% for post in posts %}
        <div class="slider-item">
          <h2>{{ post.title }}</h2>
          <img src="{{ post.thumbnail.src  }}" alt="{{ post.title }}">
        </div>
      {% endfor %}
    </div>
  </div>
</div>
```

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>We now have a simple component that takes data from our fields and outputs them on the front-end! But what if we want do pull other data in our component? The next section explores passing additional data to our component using DataFilters.</p>

  <p><a href="datafilters.md" class="btn btn-primary">Go to Section 4</a></p>
</div>
