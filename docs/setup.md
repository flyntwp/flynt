# Installation & Setup

Before continuing, please ensure that you meet all of the minimum requirements and have everything necessary installed. [You can read through the requirements here](requirements.md).

## Installing the theme (& required plugins)
1. `git clone` or copy the boilerplate repo
2. `composer install` (in boilerplate)
  - also installs sub packages (currently submodules) theme and plugins
3. Create db
4. Install wordpress via UI (install.php)

## Installing Dependencies
We use [Yarn](https://yarnpkg.com/) to manage our dependencies. To get started, you'll need to install Yarn on your system. If you do not have it installed, check out the [Yarn setup documentation](https://yarnpkg.com/en/docs/install) to learn how to do this.

Now that you have yarn installed on your system, install the theme dependencies by running the following command:
```
yarn
```

## Compile & Watch for Changes
To build the theme files and setup the local server run:
```
yarn start
```

We use [Browsersync](https://www.browsersync.io/) to watch our PHP, JS, and Stylus files, and compile and inject the changes.
