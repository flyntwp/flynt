# Setup

## Install Dependencies
We use [Yarn](https://yarnpkg.com/) to manage our dependencies. To get started, you'll need to install Yarn on your system. If you do not have it installed, check out the [Yarn setup documentation](https://yarnpkg.com/en/docs/install) to learn how to do this.

Now that you have yarn installed on your system, install the theme dependencies by running the following command:
```
yarn
```

## Compile & Watch for Changes
To build the theme files and setup the local server run:
```
yarn run flynt
```

We use [Browsersync](https://www.browsersync.io/) to watch our PHP, JS, and Stylus files, and compile and inject the changes.
