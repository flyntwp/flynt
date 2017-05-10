# flynt-starter-theme

[![standard-readme compliant](https://img.shields.io/badge/readme%20style-standard-brightgreen.svg?style=flat-square)](https://github.com/RichardLitt/standard-readme)
[![Build Status](https://travis-ci.org/flyntwp/flynt-starter-theme.svg?branch=master)](https://travis-ci.org/flyntwp/flynt-starter-theme)
[![Code Quality](https://img.shields.io/scrutinizer/g/flyntwp/flynt-starter-theme.svg)](https://scrutinizer-ci.com/g/flyntwp/flynt-starter-theme/?branch=master)

The starter theme for building [Flynt](https://flyntwp.com/) projects.

## Table of Contents

- [Background](#background)
- [Install](#install)
- [Usage](#usage)
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

**The full documentation is coming soon.**

### Theme Structure

```
flynt-starter-theme/                     # → Root of the theme
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

## Maintainers

This project is maintained by [bleech](https://github.com/bleech).

The main people in charge of this repo are:

- [Dominik Tränklein](https://github.com/domtra)
- [Doğa Gürdal](https://github.com/Qakulukiam)

## Contribute

To contribute, please use github [issues](https://github.com/flyntwp/flynt-starter-theme/issues). Pull requests are accepted.

If editing the README, please conform to the [standard-readme](https://github.com/RichardLitt/standard-readme) specification.

## License

MIT © [bleech](https://www.bleech.de)
