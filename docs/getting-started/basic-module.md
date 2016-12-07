# 2. Creating a Basic Module

<div class="alert alert-info">
  <strong>Before you begin this tutorial, make sure you first follow the <a href="../setup.md">setup instructions</a> and have your local environment up and running.
  </strong>
</div>

<div class="alert">
  <h3>This tutorial covers:</h3>
  <ul>
    <li><strong><a href="#21-configuring-page-templates">2.1 Configuring Page Templates</a></strong></li>
    <li><strong><a href="#22-creating-your-module">2.2 Creating your Module</a></strong></li>
    <li><strong><a href="#23-rendering-your-module">2.3 Rendering Your Module</a></strong></li>
  </ul>
</div>

## 2.1 Configuring Page Templates
All template files in Flynt can be found under the theme root, in the `templates` directory. You can learn more about how Flynt handles page templates [here](../theme-development/page-templates.md).

For this tutorial we will be using the default `template/page.php` template. This file contains only one line of code:

```php
Flynt\echoHtmlFromConfigFile('default.json');
```

<p><a href="/add-link" class="source-note">The source of this function can be found here in the Flynt Core plugin.</a></p>

For now, it is only important to know that our template config is actually loaded from `config/templates/default.json`.

Here we store our default page layout:

```json
{
  "name": "MainLayout",
  "dataFilter": "Flynt/DataFilters/WpBase",
  "areas": {
    "mainHeader": [
      {
        "name": "MainNavigation",
        "dataFilter": "Flynt/DataFilters/MainNavigation"
      }
    ],
    "mainTemplate": [
      {
        "name": "Template",
        "dataFilter": "Flynt/DataFilters/MainQuery/Single"
      }
    ]
  }
}
```

For a detailed look at how these template configurations work, [you can read more here](../theme-development/page-templates.md).

## 2.2 Creating your Module
All modules are located in the `Modules` directory. Create a new folder in this directory with the name `ImageSlider`.

Flynt uses [Pug PHP](https://github.com/pug-php) for view templates. To add a template for your module, create `index.php.pug` within your module folder. Your folder structure will now be:

```
flynt-theme/
├── Modules/
   └── ImagesSlider/
       └── index.php.pug
```

Whilst the end goal is to make this module an interactive slider, for now we'll add some dummy data to our view template. Open `ImageSlider/index.php.pug` and enter the following:

```jade
div(is='flynt-image-slider')
  .slider
    h1.slider-title Hello World!
```

Done! Next we need to render the module to the page.

## 2.3 Rendering Your Module

First we will create a new area for our Image Slider module. Open `config/templates/default.json` and add a new area with the key `pageModules`:

```json
{
  "name": "MainLayout",
  "dataFilter": "Flynt/DataFilters/WpBase",
  "areas": {
    ...
    "mainTemplate": [
      {
        "name": "Template",
        "dataFilter": "Flynt/DataFilters/MainQuery/Single",
        "areas": {
          "pageModules": [
            {
              "name": "ImageSlider"
            }
          ]
        }
      }
    ]
  }
}
```

Now that we have registered our area, we need to output it.

Open the `Modules/Template/index.php.pug` and replace `the_content()` with the `pageModules` area:

```jade
div(is='flynt-main-template')
  .page-wrapper(role='document')
    .main-header
      != $area('mainHeader')
    main.main-content(role='main')
      != $area('pageModules')
    .main-footer
      | Made with love by Flynt.
```

Voilà! We're done. Check out the front-end of your site and admire your new module.

<div class="alert alert-steps">
  <h2>Next Steps</h2>

  <p>In the next section we will tackle making this content dynamic - adding user-editable content fields and manipulating this data before passing it to the view.</p>

  <p><a href="dynamic-module.md" class="btn btn-primary">Go to Section 3</a></p>
</div>
