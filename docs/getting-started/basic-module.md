# Creating a Basic Module

This tutorial covers:
- Page Templates and Layout
- Creating your First Module
- Templating and Rendering Content

### Page Templates and Layout
All template files in Flynt can be found under the theme root, in the `templates/` directory. You can learn more about how Flynt handles page templates [here](../theme-development/page-templates.md).

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

Here, an area is a location within a module where it is possible to add other modules. In our default template, we only need one main area, containing our header and main template.

### Create your First Module
All modules are located in the `Modules` directory. Create a new folder in this directory with the name `PostList`).

Flynt uses [Pug PHP](https://github.com/pug-php) for templating. To add a template for your module, create an `index.php.pug` file within your new module folder. Your folder structure should now be:

```
- flynt-theme
| - Modules
  | - PostList
    | - index.php.pug
```

Now we need some test data. Open `PostList/index.php.pug` and enter the following code:

```
div(is='flynt-post-list')
  .post
    h1.post-title Hello World!
```

Next we need to render our module to the page.

## Templating and Rendering Content

.... hi
