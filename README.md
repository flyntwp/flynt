# flynt-starter-theme

[![standard-readme compliant](https://img.shields.io/badge/readme%20style-standard-brightgreen.svg?style=flat-square)](https://github.com/RichardLitt/standard-readme)
[![Build Status](https://travis-ci.org/flyntwp/flynt-starter-theme.svg?branch=master)](https://travis-ci.org/flyntwp/flynt-starter-theme)
[![Code Quality](https://img.shields.io/scrutinizer/g/flyntwp/flynt-starter-theme.svg)](https://scrutinizer-ci.com/g/flyntwp/flynt-starter-theme/?branch=master)

The starter theme for building [Flynt](https://flyntwp.com/) projects.

## Table of Contents

- [Background](#background)
- [Install](#install)
- [Usage](#usage)
  - [Configuring Page Templates](#configuring-page-templates)
  - [Components](#components)
  - [Areas](#areas)
  - [Features](#features)
  - [Theme Structure](#theme-structure)
- [Maintainers](#maintainers)
- [Contribute](#contribute)
- [License](#license)

## Background

Flynt is a sustainable approach to website development and content management with a component-based philosophy.

Flynt Theme is a ready-to-go WordPress theme that implements all of Flynt's best practices.

## Install

1. Install [Node](https://nodejs.org/en/).
2. Install [Yarn](https://yarnpkg.com/lang/en/docs/install/).
3. Create a new project folder and setup a new [WordPress](https://wordpress.org/download/) installation.
4. Install and activate the following plugins:
  - [Flynt Core](https://github.com/flyntwp/flynt-core)
  - [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/)
  - [ACF Field Group Composer](https://github.com/flyntwp/acf-field-group-composer)
  - [Timber](https://wordpress.org/plugins/timber-library/)
5. Clone the flynt-starter-theme repo to `<your-project>/wp-content/themes`.
6. Change the host variable in `flynt-starter-theme/gulpfile.js/config.js` to match your host URL.
```js
const host = 'your-host-url.dev'
```
7. In your terminal, navigate to `<your-project>/wp-content/themes/flynt-starter-theme`. Run `yarn` and then `yarn build`.
8. Go to the administrator back-end of your WordPress site and activate the `flynt-starter-theme` theme.

## Usage

In your terminal, navigate to `<your-project>/wp-content/themes/flynt-starter-theme` and run `yarn start`. This will start a local server at  `localhost:3000`.

Changes to files made in `Components` and `Features` will now be watched for changes and compiled to the `dist` folder.

### Configuring Page Templates
All template files can be found under the theme root, in the `templates` directory.

The structure of each page within the theme is created using a nested JSON object. Each PHP template within the `templates` directory takes a simple JSON configuration file, and using the Flynt Core plugin, parses and renders this into HTML.

For example, take `templates/page.php`:

```php
<?php

Flynt\echoHtmlFromConfigFile('default.json');
```

The JSON template configuration files are found in `config/templates`. These configuration files define the [components](#components) and their [areas](#areas) which are loaded into the template.

Take `config/templates/default.json` as an example. This template contains the `DocumentDefault` component, with one area within it: `layout`. The `layout` area contains the `LayoutSinglePost` component, which in turn has three nested [areas](#areas): `mainHeader`, `pageComponents`, and `mainFooter`. In addition, the `pageComponents` area contains the `ComponentLoaderFlexible` component.

```json
{
  "name": "DocumentDefault",
  "areas": {
    "layout": [
      {
        "name": "LayoutSinglePost",
        "areas": {
          "mainHeader": [],
          "pageComponents": [
            {
              "name": "ComponentLoaderFlexible",
              "customData": {
                "fieldGroup": "pageComponents"
              }
            }
          ],
          "mainFooter": []
        }
      }
    ]
  }
}
```

The `layout` area is then rendered in the `Components/DocumentDefault/index.twig` template:

```twig
<!DOCTYPE html>
<html class="flyntComponent {{ body_class }}" lang="{{ site.language }}" dir="{{ dir }}" is="flynt-document-default">
  <head><!--...--></head>
  <body role="document">
    {{ area('layout') }}
    {{ wp_footer }}
  </body>
</html>
```

### Components
A component is a self-contained building-block. As such, each component is kept within its own folder which contains everything it requires; the layout, the ACF field setup, all necessary WordPress filter and hook logic, scripting, styles, and images.

```
  ExampleComponent/
  ├── assets/
  |   ├── exampleImage.jpg
  |   └── exampleIcon.svg
  ├── fields.json
  ├── functions.php
  ├── index.twig
  ├── README.md
  ├── script.js
  ├── style.styl
```

Building components is a sustainable process, meaning every component you develop can be reused within a project, or in another; increasing your head-start with every new Flynt project.

### Areas
Since components are self-contained, areas provide a way to stack our building-blocks together. An area is simply a location within a component where it is possible to add other components.

### Features
With WordPress, it is easy to create one large `functions.php` file, crammed full of all the custom logic your theme may need. This can get messy. In Flynt, we split each piece of functionality into smaller, self-contained **feature** bundles.

In most cases, features add global hooks and filters that affect the project on a global level. With this in mind, each feature is built with reusability in mind.

Flynt comes with a core set of ready to go features, each with its own readme. To learn more, look through the [Features](https://github.com/flyntwp/flynt-starter-theme/tree/master/Features) directory.

### Theme Structure

```
flynt-starter-theme/             # → Root of the theme
├── Components/                  # → All base components
├── config/                      # → WP/ACF Configuration
│   ├── customPostTypes/         # → Configure custom post types
│   ├── fieldGroups/             # → Configure ACF field groups
│   ├── templates/               # → Page templates (JSON)
├── dist/                        # → Built theme files (never edit)
├── Features/                    # → All features
├── gulpfile.js/                 # → Gulp tasks and setup
│   ├── tasks/                   # → Individual gulp-tasks, e.g. webpack, stylus
│   ├── config.js                # → Gulp config
│   ├── index.js                 # → Load gulp tasks with config
│   ├── webpack.config.js        # → Webpack config
├── lib/                         # → Hold utils and setup features
│   ├── Utils/                   # → Small utility functions
│   ├── Bootstrap.php            # → Flynt Bootstrap
│   ├── Init.php                 # → Setup theme, register features
├── node_modules/                # → Node.js packages (never edit)
├── templates/                   # → Page templates (PHP)
├── .gitignore                   # → Files/Folders that will not be committed to Git.
├── .stylintrc                   # → Define Stylus linting rules
├── bower.json                   # → Bower dependencies
├── functions.php                # → Set template directory and load lib/Init.php
├── index.php                    # → Theme entry point (never edit)
├── package.json                 # → Node.js dependencies and scripts
├── phpcs.ruleset.xml            # → Define PHP linting rules
├── screenshot.png               # → Theme screenshot for WP admin
├── style.css                    # → Required WordPress theme style file.
├── yarn.lock                    # → Yarn lock file (never edit)
```

[You can read the full documentation here.](https://docs.flyntwp.com)

## Maintainers

This project is maintained by [bleech](https://github.com/bleech).

The main people in charge of this repo are:

- [Dominik Tränklein](https://github.com/domtra)
- [Doğa Gürdal](https://github.com/Qakulukiam)

## Contribute

To contribute, please use GitHub [issues](https://github.com/flyntwp/flynt-starter-theme/issues). Pull requests are accepted. Please also take a moment to read the [Contributing Guidelines](https://github.com/flyntwp/guidelines/blob/master/CONTRIBUTING.md) and [Code of Conduct](https://github.com/flyntwp/guidelines/blob/master/CODE_OF_CONDUCT.md).

If editing the README, please conform to the [standard-readme](https://github.com/RichardLitt/standard-readme) specification.

## License

MIT © [bleech](https://www.bleech.de)
