# Change Log

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

<a name="0.2.0"></a>
# [0.2.0](https://github.com/flyntwp/flynt-starter-theme/compare/v0.1.0...v0.2.0) (2017-06-14)


### Bug Fixes

* **archive:** Use archive.json instead of non-existent archive-unfiltered.json (#194) ([b4b3baa](https://github.com/flyntwp/flynt-starter-theme/commit/b4b3baa))
* **Components:** use correct image sizes and ratios (#221) ([b2b69ac](https://github.com/flyntwp/flynt-starter-theme/commit/b2b69ac)), closes [#198](https://github.com/flyntwp/flynt-starter-theme/issues/198)
* **Components/DocumentDefault:** add woff2 option to fontFace helper (#197) ([d90fb64](https://github.com/flyntwp/flynt-starter-theme/commit/d90fb64))
* **Components/DocumentDefault:** remove duplicate class attribute on html element (#171) ([0a56ffa](https://github.com/flyntwp/flynt-starter-theme/commit/0a56ffa))
* **Components/SliderMedia:** resolve several issues (#196) ([9383082](https://github.com/flyntwp/flynt-starter-theme/commit/9383082)), closes [#196](https://github.com/flyntwp/flynt-starter-theme/issues/196)
* **Features/Acf:** use ucfirst on all names to keep consistent filter names (#199) ([ddc7806](https://github.com/flyntwp/flynt-starter-theme/commit/ddc7806))
* **Features/Acf/OptionPages:** use correct updated get method internally ([650837a](https://github.com/flyntwp/flynt-starter-theme/commit/650837a))
* **Features/AdminComponentPreview:** use correct assets path and url (#170) ([e2cb5e6](https://github.com/flyntwp/flynt-starter-theme/commit/e2cb5e6))
* **Features/Components:** sort components before registering them (#166) ([c8e7087](https://github.com/flyntwp/flynt-starter-theme/commit/c8e7087))
* **lib/Bootstrap:** require ACF plugin (#173) ([975c529](https://github.com/flyntwp/flynt-starter-theme/commit/975c529)), closes [#139](https://github.com/flyntwp/flynt-starter-theme/issues/139)
* **Utils/Log:** json_encode all data and add console method validation (#211) ([28419e9](https://github.com/flyntwp/flynt-starter-theme/commit/28419e9))


### Code Refactoring

* **Features/Acf/OptionPages:** use single public function and fix CPT subpage name (#167) ([99aa561](https://github.com/flyntwp/flynt-starter-theme/commit/99aa561)), closes [#167](https://github.com/flyntwp/flynt-starter-theme/issues/167)


### Features

* **Components/BlockImage:** add component (#182) ([3db3b60](https://github.com/flyntwp/flynt-starter-theme/commit/3db3b60))
* **Components/BlockMediaText:** add component (#183) ([bb9ccfd](https://github.com/flyntwp/flynt-starter-theme/commit/bb9ccfd))
* **Components/BlockNotFound:** add component (#186) ([cfde1e2](https://github.com/flyntwp/flynt-starter-theme/commit/cfde1e2))
* **Components/BlockVideoOembed:** add component (#184) ([4f1835d](https://github.com/flyntwp/flynt-starter-theme/commit/4f1835d))
* **Components/BlockWysiwyg:** add component (#179) ([9d08f57](https://github.com/flyntwp/flynt-starter-theme/commit/9d08f57))
* **Components/ListPosts:** add component (#185) ([5797b2e](https://github.com/flyntwp/flynt-starter-theme/commit/5797b2e))
* **Components/NavigationMain:** add component (#180) ([37aa956](https://github.com/flyntwp/flynt-starter-theme/commit/37aa956))
* **Components/SliderMedia:** add component (#181) ([355188b](https://github.com/flyntwp/flynt-starter-theme/commit/355188b))
* **Features/HideProtectedPosts:** Remove password protected posts from query (#205) ([6f4b531](https://github.com/flyntwp/flynt-starter-theme/commit/6f4b531))
* **Features/TinyMce:** customize editor via JSON config file (#158) ([faeebb7](https://github.com/flyntwp/flynt-starter-theme/commit/faeebb7))
* **lib/Utils:** add getContents method to Asset Util (#222) ([0c06ba3](https://github.com/flyntwp/flynt-starter-theme/commit/0c06ba3))
* **Utils/Asset, Features/Jquery:** add CDN option to asset util and implement in Jquery feature (#168) ([68bc9e1](https://github.com/flyntwp/flynt-starter-theme/commit/68bc9e1)), closes [#131](https://github.com/flyntwp/flynt-starter-theme/issues/131)
* **Utils/Log:** add default option to postpone logs to wp_footer (#203) ([ae0c62a](https://github.com/flyntwp/flynt-starter-theme/commit/ae0c62a))


### BREAKING CHANGES

* **lib/Bootstrap:** not used anywhere else, but still a public method name that changed

* style(lib/Bootstrap): fix linting error opening brace on same line

* fix(lib/Bootstrap): add missing parameter to function closure
* **Features/Acf/OptionPages:** Removed OptionPages::getOption and OptionPages::getOptions. Using OptionPages::get instead.

* fix(Features/Acf/OptionPages): convert custom post type option sub page name to camelCase



<a name="0.1.0"></a>
# 0.1.0 (2017-05-02)


## Initial Release
