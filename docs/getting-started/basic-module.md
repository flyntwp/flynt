# 2. Creating a Basic Module

This tutorial covers:
- [2.1 Configuring Page Templates](#21-configuring-page-templates)
- [2.2 Creating your Module](#22-creating-your-module)
- [2.3 Rendering Your Module](#23-rendering-your-module)

**Before you begin this tutorial, make sure you first follow the [setup instructions](../setup.md) and have your local environment up and running.**

## 2.1 Configuring Page Templates
Before we get started with creating our module, it is important to first understand how page templates are configured.

All template files in Flynt can be found under the theme root, in the `templates` directory. You can learn more about how Flynt handles page templates [here](../theme-development/page-templates.md).

For this tutorial we will be using the default `template/page.php` template. This file contains only one line of code:

```php
<?php
Flynt\echoHtmlFromConfigFile('default.json');
```

The source of this function can be found in the core Flynt Plugin. [You can read more about it in the plugin documentation](/add-link). For now, you should know that our template config is actually loaded from `config/templates/default.json`. Here we store our default page layout:

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

For a detailed look at how these templates work, [you can read more here](/add-link). For now, it is only important to know that an area is a location within a module where it is possible to add other modules.

## 2.2 Creating your Module
All modules are located in the `Modules` directory. Create a new folder in this directory with the name `ImageSlider`).

Flynt uses [Pug PHP](https://github.com/pug-php) for templating. To add a template for your module, create an `index.php.pug` file within your new module folder. Your folder structure should now be:

```
- flynt-theme
| - Modules
  | - ImageSlider
    | - index.php.pug
```

For now we'll need to add some dummy data to our view template (we'll come back to make this an interactive slider in [section 3 of this tutorial](module-assets.md)). Open `ImageSlider/index.php.pug` and enter the following code:

```jade
div(is='flynt-image-slider')
  .slider
    h1.slider-title Hello World!
```

Done! Next we need to render our module to the page.

## 2.3 Rendering Your Module

First we will create a new area for our Image Slider module. Open `config/templates/default.json` and add the new `pageModules` area as in the code below:

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

Now that we have registered our area, we need to output it. Open the `Modules/Template/index.php.pug` and replace `the_content()` with our new `pageModules` area:

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

Voilá! Check out the front-end of your site and admire your template in all its glory.

---

## Next Steps

In the next section we will tackle making this content dynamic - adding user-editable content fields and manipulating this data before passing it to the view.

**[Go to Section Two](dynamic-module.md)**

<!-- Stop looking at the source and go build some modules! ;-) -->
