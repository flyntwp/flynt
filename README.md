![Flynt – WordPress Starter Theme for Developers](.github/assets/banner.svg 'Flynt – WordPress Starter Theme for Developers')

# Fall in love with WordPress (again)

[![standard-readme compliant](https://img.shields.io/badge/readme%20style-standard-brightgreen.svg?style=flat-square)](https://github.com/RichardLitt/standard-readme)
[![Build Status](https://travis-ci.org/flyntwp/flynt.svg?branch=master)](https://travis-ci.org/flyntwp/flynt)
[![Code Quality](https://img.shields.io/scrutinizer/g/flyntwp/flynt.svg)](https://scrutinizer-ci.com/g/flyntwp/flynt/?branch=master)

[Flynt](https://flyntwp.com/) is a lightning-fast WordPress Starter Theme for component-based development with [ACF Pro](#advanced-custom-fields).

## Dependencies

* [WordPress](https://wordpress.org/) >= 6.1
* [Node](https://nodejs.org/en/) = 20
* [Composer](https://getcomposer.org/download/) >= 2.4
* [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) >= 6.0

## Install

1. Clone this repo to `<your-project>/wp-content/themes`.
2. Change the domain variable in `flynt/vite.config.js` to match your domain:
`const wordpressHost = 'http://your-project.test'`
3. Navigate to the theme folder and run the following command in your terminal:

```
# wp-content/themes/flynt
composer install
npm install
npm run build
```

4. Open the WordPress backend and activate the Flynt theme.

## Usage

To start developing run the following command:

```
# wp-content/themes/flynt
npm start
```

All files in `assets` and `Components` will now be watched for changes and served. Happy coding!

### Build

After developing it is required to generate compiled files in the `./dist` folder.

To generate the compiled files, run the following command:

```
# wp-content/themes/flynt
npm run build
```

To skip the linting process (optional) and to generate the compiled files, run the command:

```
# wp-content/themes/flynt
npm run build:production
```

### Base Style

Flynt comes with a ready to use Base Style built according to our best practices for building simple, maintainable components. Go to `domain/BaseStyle` to see it in action.

### Assets

The `./assets` folder contains all global JavaScript, SCSS, images, and font files for the theme. Files inside this folder are watched for changes and compile to `./dist`.

The `main.scss` file is compiled to `./dist/assets/main.css` which is enqueued in the front-end.

The `admin.scss` file is compiled to `./dist/assets/admin.css` which is enqueued in the administrator back-end of WordPress, so styles added to this file will take effect only in the back-end.

### Lib & Inc

The `./lib` folder includes helper functions and basic setup logic. *You will most likely not need to modify any files inside `./lib`.* All files in the `./lib` folder are autoloaded via PSR-4.

The `./inc` folder is a more organised version of WordPress' `functions.php` and contains all custom theme logic. All files in the `./inc` folder are automatically required.

For organisation, `./inc` has three subfolders. We recommend using these three folders to keep the theme well-structured:

* `customPostTypes`<br> Use this folder to register custom WordPress post types.
* `customTaxonomies`<br> Use this folder to register custom WordPress taxonomies.
* `fieldGroups`<br> Use this folder to register Advanced Custom Fields field groups. (See [Field Groups](#field-groups) for more information.)

After the files from `./lib` and `./inc` are loaded, all [components](#components) from the `./Components` folder are loaded.

### Page Templates

Flynt uses [Timber](https://www.upstatement.com/timber/) to structure its page templates and [Twig](https://twig.symfony.com/) for rendering them. [Timber's documentation](https://timber.github.io/docs/) is extensive and up to date, so be sure to get familiar with it.

As part of the [Twig Extension](#twig-extensions) the theme uses a Twig function in to render components into templates:

* `renderComponent(componentName, data)` renders a single component. [For example, in the `index.twig` template](https://github.com/flyntwp/flynt/tree/master/templates/index.twig).

Besides the main document structure (in `./templates/_document.twig`), everything else is a component.

### Components

A component is a self-contained building-block. Each component contains its own layout, its ACF fields, PHP logic, scripts, and styles.

```
  ExampleComponent/
  ├── _style.scss
  ├── functions.php
  ├── index.twig
  ├── README.md
  ├── screenshot.png
  ├── script.js
```

The `functions.php` file for every component in the `./Components` folder is executed during the WordPress action `after_setup_theme`. [This is run from the `./functions.php` file of the theme.](https://github.com/flyntwp/flynt/tree/master/functions.php)

To render components into a template, see [Page Templates](#page-templates).

#### Web Components

Web components provide a standard component model for encapsulation and interoperability HTML elements. Most [components](#components) are based on an autonomous custom element called `flynt-component`.

To define the name of a specific component use the `name` attribute, which should match the component’s folder name, to be ensure that its JavaScript is loaded as specified (see [JavaScript modules](#javascript-modules) for more details).

For example:

```twig
<flynt-component name="BlockWysiwyg" …></flynt-component>
```

#### JavaScript modules

Using a module based approach, allows to breaks JavaScript into separate files and keep them encapsuled inside [Components](#components) itself.

Different loading strategies can be defined for each component independently when using the custom element `flynt-component`:

* `load:on="idle"`<br>
Initialises after full page load, when the browser enters idle state.<br>
Usage example: Elements that don’t need to be interactive immediately.
* `load:on="visible"`<br>
Initialises after the element get visible in the viewport.<br>
Usage example: Elements that go “below the fold” or should be loaded when the user sees them.
* `load:on="load"` (default)<br>
Initialises immediately when the page loads.<br>
Usage example: Elements that need to be interactive as soon as possible.
* `load:on:media="(min-width: 1024px)"`<br>
Initialises when the specified media query matches.<br>
Usage example: Elements which may only be visible on certain screen sizes.

Example:

```twig
<flynt-component name="BlockWysiwyg" load:on="visible"></flynt-component>
```

If it makes logical sense, loading strategies can be combined:

```twig
<flynt-component name="NavigationMain" load:on="idle" load:on:media="(min-width: 1024px)">
```

With nested components the loading strategy is waiting for parents. If you have a component with `load:on="idle"` nested inside a component with `load:on="visible"`, the child component will only be loaded on visible of the parent component.

### Advanced Custom Fields

Defining Advanced Custom Fields (ACF) can be done in `functions.php` for each component. As a best practice, we recommend defining your fields inside a function named `getACFLayout()` which you can then call in a [field group](#field-groups).

For example:

```php
namespace Flynt\Components\BlockWysiwyg;

function getACFLayout()
{
    return [
        'name' => 'blockWysiwyg',
        'label' => __('Block: Wysiwyg', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 0,
                'media_upload' => 0,
                'required' => 1,
            ],
        ]
    ];
}
```

### Field Groups

Field groups are needed to show registered fields in the WordPress back-end. All field groups are created in the `./inc/fieldGroups` folder. Two field groups exist by default: [`pageComponents.php`](https://github.com/flyntwp/flynt/tree/master/inc/fieldGroups/pageComponents.php) and [`postComponents.php`](https://github.com/flyntwp/flynt/tree/master/inc/fieldGroups/postComponents.php).

We call the function `getACFLayout()` defined in the `functions.php` file of each component to load fields into a field group.

For example:

```php
use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => 'Page Components',
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => __('Page Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    Components\BlockWysiwyg\getACFLayout(),
                ]
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page'
                ]
            ]
        ]
    ]);
});
```

Here we use the [ACF Field Group Composer](https://github.com/flyntwp/acf-field-group-composer) plugin, which provides the advantage that all fields automatically get a unique key.

### ACF Option Pages

Flynt includes several utility functions for creating Advanced Custom Fields options pages. Briefly, these are:

* `Flynt\Utils\Options::addTranslatable`<br> Adds fields into a new group inside the Translatable Options options page. When used with the WPML plugin, these fields will be returned in the current language.
* `Flynt\Utils\Options::addGlobal`<br> Adds fields into a new group inside the Global Options options page. When used with WPML, these fields will always be returned from the primary language. In this way these fields are *global* and cannot be translated.
* `Flynt\Utils\Options::getTranslatable` <br> Retrieve a translatable option.
* `Flynt\Utils\Options::getGlobal` <br> Retrieve a global option.

### Timber Dynamic Resize

Timber provides [a `resize` filter to resize images](https://timber.github.io/docs/reference/timber-imagehelper/#resize) on first page load. Resizing many images at the same time can result in a server timeout. That's why Flynt provides a `resizeDynamic` filter, that resizes images asynchronously upon first request of the image itself. Resized images are stored in `uploads/resized`. To regenerate all image sizes and file versions, delete the folder.

To enable Dynamic Resize, go to **Global Options -> Timber Dynamic Resize**.

### Twig Extensions

#### `readingTime` (Type: Filter)

Returns the reading time of a string in minutes.

```twig
{{ 'This is a string'|readingTime }}
```

*Example from [Components/GridPostsArchive/index.twig](./Components/GridPostsArchive/index.twig)*

---

#### `renderComponent($componentName, $data)` (Type: Function)

Renders a component. [See Page Templates](#page-templates).

```twig
{% for component in post.meta('pageComponents') %}
    {{ renderComponent(component) }}
{% endfor %}
```

*Example from [templates/page.twig](./templates/page.twig)*

#### `placeholderImage($width, $height, $color = null)` (Type: Function)

Useful in combination with lazysizes for lazy loading. Returns a "data:image/svg+xml;base64" placeholder image.

```twig
{{ placeholderImage(768, 512, 'rgba(125, 125, 125, 0.1)') }}
```

*Example from [Components/BlockImage/index.twig](./Components/BlockImage/index.twig)*

---

#### `resizeDynamic($src, $w, $h = 0, $crop = 'default', $force = false)` (Type: Filter)

Resizes an image dynamically. [See Timber Dynamic Resize](#timber-dynamic-resize).

```twig
{{ post.thumbnail.src|resizeDynamic(1920, (1920 / 3 * 2)|round, 'center') }}
```

*Example from [Components/BlockImage/index.twig](./Components/BlockImage/index.twig)*

---

## Troubleshooting

### Images

In some setups images may not show up, returning a 404 by the server.

The most common reason for this is that you are using nginx and your server is not set up in the [the recommended standard](https://wordpress.org/support/article/nginx/#general-wordpress-rules). You can see that this is the case, if an image url return a 404 from nginx, not from WordPress itself.

In this case, please add something like

```nginx
location ~ "^(.*)/wp-content/uploads/(.*)$" {
  try_files $uri $uri/ /index.php$is_args$args;
}
```

to your site config.

Other issues might come from Flynt not being able to determine the relative url of your uploads folder. If you have a non-standard WordPress folder structure, or if you use a plugin that manipulates `home_url` (for example, [WPML](https://wpml.org/)) this can cause problems when using `resizeDynamic`.

In this care try to set the relative upload path manually and refresh the permalink settings in the back-end:

```php
add_filter('Flynt/TimberDynamicResize/relativeUploadDir', function () {
    return 'app/uploads'; // Example for Bedrock installs.
});
```

### SSL certificate for dev server

If you want to use https in development, please define the following variables inside a `.env` file:

```
VITE_DEV_SERVER_HOST=https://your-project.test
VITE_DEV_SERVER_KEY=<path-to-ssl-certificate-key>/your-project.test_key.pem
VITE_DEV_SERVER_CERT=<path-to-ssl-certificate-cert>/your-project.test_cert.pem
```

## Maintainers

This project is maintained by [Bleech](https://bleech.de/en/).

The main people in charge of this repo are:

* [Steffen Bewersdorff](https://github.com/steffenbew)
* [Dominik Tränklein](https://github.com/domtra)
* [Timo Hubois](https://github.com/timohubois)
* [Harun Bašić](https://github.com/harunbleech)

## Contributing

To contribute, please use GitHub [issues](https://github.com/flyntwp/flynt/issues). Pull requests are accepted. Please also take a moment to read the [Contributing Guidelines](https://github.com/flyntwp/guidelines/blob/master/CONTRIBUTING.md) and [Code of Conduct](https://github.com/flyntwp/guidelines/blob/master/CODE_OF_CONDUCT.md).

If editing the README, please conform to the [standard-readme](https://github.com/RichardLitt/standard-readme) specification.

## License

MIT © [Bleech](https://bleech.de/en/)
