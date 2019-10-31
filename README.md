# Flynt

[![standard-readme compliant](https://img.shields.io/badge/readme%20style-standard-brightgreen.svg?style=flat-square)](https://github.com/RichardLitt/standard-readme)
[![Build Status](https://travis-ci.org/flyntwp/flynt-starter-theme.svg?branch=master)](https://travis-ci.org/flyntwp/flynt-starter-theme)
[![Code Quality](https://img.shields.io/scrutinizer/g/flyntwp/flynt-starter-theme.svg)](https://scrutinizer-ci.com/g/flyntwp/flynt-starter-theme/?branch=master)

## Short Description
[Flynt](https://flyntwp.com/) is a WordPress theme for component-based development using [Timber](#page-templates) and [Advanced Custom Fields](#advanced-custom-fields).

## Table of Contents
* [Install](#install)
  * [Dependencies](#dependencies)
* [Usage](#usage)
  * [Assets](#assets)
  * [Lib & Inc](#lib--inc)
  * [Page Templates](#page-templates)
  * [Components](#components)
  * [Advanced Custom Fields](#advanced-custom-fields)
  * [Field Groups](#field-groups)
  * [ACF Option Pages](#acf-option-pages)
  * [WPML](#wpml)
* [Maintainers](#maintainers)
* [Contributing](#contributing)
* [License](#license)

## Install
1. Clone this repo to `<your-project>/wp-content/themes`.
2. Change the host variable in `flynt/build-config.js` to match your host URL: `const host = 'your-project.test'`
3. Navigate to the theme folder and run the following command in your terminal:
```
# wp-content/themes/flynt
composer install && npm i && npm run build
```
4. Open the WordPress back-end and activate the Flynt theme.

### Dependencies
* [WordPress](https://wordpress.org/) >= 5.0
* [Node](https://nodejs.org/en/) = 10
* [Composer](https://getcomposer.org/download/) >= 1.8
* [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) >= 5.7

## Usage
In your terminal, navigate to `<your-project>/wp-content/themes/flynt` and run `npm start`. This will start a local server at `localhost:3000`.

All files in `assets`,  `Components` and `Features` will now be watched for changes and compiled to the `dist` folder. Happy coding!

### Assets

The `./assets` folder contains all SCSS, images, and font files for the theme. Files inside this folder are watched for changes and compile to `./dist`.

The `main.scss` file is compiled to `./dist/assets/main.css` which is enqueued in the front-end.

The `admin.scss` file is compiled to `./dist/assets/admin.css` which is enqueued in the administrator back-end of WordPress, so styles added to this file will take effect only in the back-end.

### Lib & Inc

All PHP files from `./lib` and `./inc` are automatically required.

The `./lib` folder includes helper functions and basic setup logic. *You will most likely not need to modify any files inside `./lib`.*

The `inc` folder is a more organised version of WordPress' `functions.php` and contains all custom theme logic.

For organisation, `./inc` has three subfolders. We recommend using these three folders to keep the theme well-structured:

- `customPostTypes`<br> Use this folder to register custom WordPress post types.
- `customTaxonomies`<br> Use this folder to register custom WordPress taxonomies.
- `fieldGroups`<br> Use this folder to register Advanced Custom Fields field groups. (See [Field Groups](#field-groups) for more information.)

After the files from './lib' and './inc' are loaded, all [components](#components) from the `./Components` folder are loaded.

### Page Templates
Flynt uses [Timber](https://www.upstatement.com/timber/) to structure its page templates and [Twig](https://twig.symfony.com/) for rendering them. [Timber's documentation](https://timber.github.io/docs/) is extensive and up to date, so be sure to get familiar with it.

There are two Twig functions added in Flynt to render components into templates:
* `renderComponent(componentName, data)` renders a single component. [For example, in the `index.twig` template](https://github.com/flyntwp/flynt/tree/master/templates/index.twig).
* `renderFlexibleContent(flexibleContentField)` renders all components passed from an Advanced Custom Fields *Flexible Content* field. [For example, in the `single.twig` template.](https://github.com/flyntwp/flynt/tree/master/templates/single.twig)

Besides the main document structure (in `./templates/_document.twig`), everything else is a component.

### Components
A component is a self-contained building-block. Each component contains its own layout, its ACF fields, PHP logic, scripts, and styles.

```
  ExampleComponent/
  ├── functions.php
  ├── index.twig
  ├── README.md
  ├── screenshot.png
  ├── script.js
  ├── style.scss
```

The `functions.php` file for every component in the `./Components` folder is executed during the WordPress action `after_setup_theme`. [This is run from the `./functions.php` file of the theme.](https://github.com/flyntwp/flynt/tree/master/functions.php)

To render components into a template, see [Page Templates](#page-templates).

### Advanced Custom Fields
To define Advanced Custom Fields (ACF) for a component, use `Flynt\Api\registerFields`. This has 3 arguments:

```php
Flynt\Api\registerFields($scope = 'ComponentName', $fields = [], $fieldId = null);
```

`$scope` is the name of the component, `$fields` are the ACF fields you want to register, and `$fieldsId` is an optional (rarely needed) parameter for registering multiple fields for a single scope.

For example:

```php
use Flynt\Api;

Api::registerFields('BlockWysiwyg', [
    'layout' => [
        'name' => 'blockWysiwyg',
        'label' => 'Block: Wysiwyg',
        'sub_fields' => [
            [
                'name' => 'contentHtml',
                'label' => 'Content',
                'type' => 'wysiwyg',
                'required' => 1,
            ]
        ]
    ]
]);
```

In the example above, the `layout` array is required in order to load this component into an Advanced Custom Fields *Flexible Content* field.

### Field Groups
Field groups are needed to show registered fields in the WordPress back-end. All  field groups are created in the `./inc/fieldGroups` folder. Two field groups exist by default: [`pageComponents.php`](https://github.com/flyntwp/flynt/tree/master/inc/templates/pageComponents.php) and [`postComponents.php`](https://github.com/flyntwp/flynt/tree/master/inc/templates/postComponents.php).

To include fields that have been registered with `Flynt\Api::registerFields`, use `ACFComposer::registerFieldGroup($config)` inside the Inside the `Flynt/afterRegisterComponents` action.

Use `Flynt\Api::loadFields($scope, $fieldPath = null)` to load groups of fields into a field group. For example:

```php
use ACFComposer\ACFComposer;
use Flynt\Api;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => 'Page Components',
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => 'Page Components',
                'type' => 'flexible_content',
                'button_label' => 'Add Component',
                'layouts' => [
                    Api::loadFields('BlockWysiwyg', 'layout'),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ],
            ],
        ],
    ]);
});
```

The `registerFieldGroup` function takes the same argument as Advanced Custom Fields's `acf_add_local_field_group` with two exceptions:

1. The fields do not require field keys but are automatically generated.
2. For conditional logic, instead for specifying a field key as reference, you can specify a field path. For example:

```php
[
  'label' => 'Include Button',
  'name' => 'includeButton',
  'type' => 'true_false',
],
[
    'label' => 'Button Text',
    'name' => 'buttonText',
    'type' => 'text',
    'conditional_logic' => [
        [
            [
                'fieldPath' => 'includeButton',
                'operator' => '==',
                'value' => 1'
            ]
        ]
    ]
]
```

Conditional logic can also target fields one level higher. This is useful when targetting fields inside of a repeater. For example:

```php
[
    'label' => 'Include Buttons',
    'name' => 'includeButtons',
    'type' => 'true_false',
],
[
    'label' => 'Items',
    'type' => 'repeater',
    'name' => 'items',
    'sub_fields' => [
        [
            'label' => 'Button Text',
            'name' => 'buttonText',
            'type' => 'text',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => '../includeButtons',
                        'operator' => '==',
                        'value' => 1
                    ]
                ]
            ]
        ]
    ]
]


```

More information can be found in the [ACF Field Group Composer repository](https://github.com/flyntwp/acf-field-group-composer).

Registered fields can also be used statically (not inside a flexible content field). To do this, we strongly suggest putting the fields for a component in an ACF group field, so that you are able to easily retrieve all the associated fields.

For Example:

```php
use ACFComposer\ACFComposer;
use Flynt\Api;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => 'Page Components',
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'mainContent',
                'label' => 'Main Content',
                'type' => 'group',
                'sub_fields' => [
                    Api::loadFields('BlockWysiwyg', 'layout.sub_fields'),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ],
            ],
        ],
    ]);
});
```

### ACF Option Pages
Flynt includes several utility functions for creating Advanced Custom Fields options pages. Briefly, these are:

* `Flynt\Utils\Options::addTranslatable`<br> Adds fields into a new group inside the Translatable Options options page. When used with the WPML plugin, these fields will be returned in the current language.
* `Flynt\Utils\Options::addGlobal`<br> Adds fields into a new group inside the Global Options options page. When used with WPML, these fields will always be returned from the primary language. In this way these fields are *global* and cannot be translated.
* `Flynt\Utils\Options::get` <br> Used to retrieve options from Translatable or Global options.

## Maintainers
This project is maintained by [bleech](https://github.com/bleech).

The main people in charge of this repo are:
* [Dominik Tränklein](https://github.com/domtra)
* [Doğa Gürdal](https://github.com/Qakulukiam)

## Contributing
To contribute, please use GitHub [issues](https://github.com/flyntwp/flynt/issues). Pull requests are accepted. Please also take a moment to read the [Contributing Guidelines](https://github.com/flyntwp/guidelines/blob/master/CONTRIBUTING.md) and [Code of Conduct](https://github.com/flyntwp/guidelines/blob/master/CODE_OF_CONDUCT.md).

If editing the README, please conform to the [standard-readme](https://github.com/RichardLitt/standard-readme) specification.

## License
MIT © [bleech](https://www.bleech.de)
