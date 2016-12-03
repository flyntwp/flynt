# 1. Creating a Basic Module

This tutorial covers:
- [Page Templates and Layout](#page-templates-and-layout)
- [Creating your Module](#creating-your-module)
- [Rendering Your Module](#rendering-your-module)

Before you begin this tutorial, make sure you first follow the [setup instructions](../setup.md) and have your local environment up and running.

## Page Templates and Layout
All template files in Flynt can be found under the theme root, in the `templates` directory. You can learn more about how Flynt handles page templates [here](../theme-development/page-templates.md).

For this tutorial we will be using the default `template/page.php` template. This file contains only one line of code:

```php
<?php
Flynt\echoHtmlFromConfigFile('default.json');
```

This is because the template config is actually loaded from `config/templates/default.json`. Here we store our default page layout:

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

For a detailed look at how these templates work, [you can read more here](). For now, it is only important to know that an area is a location within a module where it is possible to add other modules.

## Creating your Module
All modules are located in the `Modules` directory. Create a new folder in this directory with the name `MediaSlider`).

Flynt uses [Pug PHP](https://github.com/pug-php) for templating. To add a template for your module, create an `index.php.pug` file within your new module folder. Your folder structure should now be:

```
- flynt-theme
| - Modules
  | - MediaSlider
    | - index.php.pug
```

Now we need some test data. Open `MediaSlider/index.php.pug` and enter the following code:

```jade
.post-list
  .post
    h1.post-title Hello World!
```

Next we need to render our module to the page.

## Rendering Your Module

First we will create a new area for our MediaSlider module. Open `config/templates/default.json` and add the new `pageModules` area as in the code below:

```json
{
  "mainTemplate": [
    {
      "name": "Template",
      "dataFilter": "Flynt/DataFilters/MainQuery/Single",
      "areas": {
        "pageModules": [
          {
            "name": "MediaSlider"
          }
        ]
      }
    }
  ]
}
```

Now that we have registered our area, we need to output it. Open the `Modules/Template/index.php.pug` and replace `the_content()` with our new `pageModules` area:

```jade
.main-template
  .page-wrapper(role='document')
    .main-header
      != $area('mainHeader')
    main.main-content(role='main')
      != $area('pageModules')
    .main-footer
      | Made with love by Flynt.
```

Voilá! Check out the front-end of your site and admire your "Hello World" Media Slider in all its glory.

Next we will use Advanced Custom Fields to add some user-editable content fields to the Wordpress backend.

<!-- Stop looking at the source and go build some modules! ;-) -->
