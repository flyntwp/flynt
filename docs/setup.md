# Installation & Setup

Before continuing, please ensure that you meet all of the minimum requirements and have everything necessary installed. [You can read through the requirements here](requirements.md).

## Installing the Framework

For the sake of an easy and fast setup process, we recommend using the `flynt-cli` tool to create a new project. This installs the following parts of the Flynt Framework:
- Flynt / Bedrock Boilerplate
- Flynt Theme
- Flynt Core Plugin
- ACF Field Group Composer Plugin

### A. Using the Flynt CLI Tool
1. Set up your Virtual Host and Database
3. Install the flynt-cli tool globally via yarn or npm
4. Run `flynt init <project-name>`. This guides you through the process of creating all necessary dependencies (including Wordpress!) and sets up the Flynt Framework using our recommended [best practices](add_link).
5. Run the Wordpress Setup script via the web interface.
6. Optional: Init your git repo if you want (theme or boilerplate, up to you).

### B. Installing the Flynt Theme manually
1. Create your own wordpress setup (if you are not using bedrock)
2. `git clone` or copy the flynt-theme

## Start it up
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
