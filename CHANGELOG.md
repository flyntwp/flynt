# Change Log

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

<a name="0.4.0"></a>
# [0.4.0](https://github.com/flyntwp/flynt-starter-theme/compare/v0.3.1...v0.4.0) (2018-07-19)


### Bug Fixes

* **DocumentDefault:** enable zoom by default ([#278](https://github.com/flyntwp/flynt-starter-theme/issues/278)) ([2bfd385](https://github.com/flyntwp/flynt-starter-theme/commit/2bfd385))
* **Features/TimberLoader:** use relative file path in renderComponent hook ([#265](https://github.com/flyntwp/flynt-starter-theme/issues/265)) ([886c94e](https://github.com/flyntwp/flynt-starter-theme/commit/886c94e))
* **gulpfile.js:** fix reloading of PHP files outside the copy scope ([#283](https://github.com/flyntwp/flynt-starter-theme/issues/283)) ([c0e8779](https://github.com/flyntwp/flynt-starter-theme/commit/c0e8779))
* **yarn:** set version constraint for document-register-element to ~1.8.0 ([#282](https://github.com/flyntwp/flynt-starter-theme/issues/282)) ([32160d1](https://github.com/flyntwp/flynt-starter-theme/commit/32160d1))


### Features

* **DocumentDefault, Layouts:** add sticky footer styles ([#280](https://github.com/flyntwp/flynt-starter-theme/issues/280)) ([6263ffc](https://github.com/flyntwp/flynt-starter-theme/commit/6263ffc))
* **Features/CustomTaxonomies:** add public getAll method ([#277](https://github.com/flyntwp/flynt-starter-theme/issues/277)) ([40fb705](https://github.com/flyntwp/flynt-starter-theme/commit/40fb705))
* **Features/Lodash:** add lodash feature ([#284](https://github.com/flyntwp/flynt-starter-theme/issues/284)) ([112b4d3](https://github.com/flyntwp/flynt-starter-theme/commit/112b4d3))
* **Features/TimberLoader:** add template file name filter ([#279](https://github.com/flyntwp/flynt-starter-theme/issues/279)) ([769a7ef](https://github.com/flyntwp/flynt-starter-theme/commit/769a7ef))


### Performance Improvements

* **gulpfile.js:** improve initial startup time ([#276](https://github.com/flyntwp/flynt-starter-theme/issues/276)) ([a98dd11](https://github.com/flyntwp/flynt-starter-theme/commit/a98dd11))


### BREAKING CHANGES

* **gulpfile.js:** The minimum engine requirement is now Node >= 8.



<a name="0.3.1"></a>
## [0.3.1](https://github.com/flyntwp/flynt-starter-theme/compare/v0.3.0...v0.3.1) (2018-04-18)


### Bug Fixes

* **.gitignore:** add yarn error log ([#268](https://github.com/flyntwp/flynt-starter-theme/issues/268)) ([4e04b47](https://github.com/flyntwp/flynt-starter-theme/commit/4e04b47))
* **Features/Acf:** set correct toggle selector after ACF update ([#264](https://github.com/flyntwp/flynt-starter-theme/issues/264)) ([689b580](https://github.com/flyntwp/flynt-starter-theme/commit/689b580))


### Features

* **Components:** update DocumentDefault, Layouts and variables ([#271](https://github.com/flyntwp/flynt-starter-theme/issues/271)) ([0c7ecb6](https://github.com/flyntwp/flynt-starter-theme/commit/0c7ecb6))



<a name="0.3.0"></a>
# [0.3.0](https://github.com/flyntwp/flynt-starter-theme/compare/v0.2.2...v0.3.0) (2017-10-16)


### Bug Fixes

* **config/fieldGroups:** hide pageComponents on the posts page by default ([#256](https://github.com/flyntwp/flynt-starter-theme/issues/256)) ([da6b99f](https://github.com/flyntwp/flynt-starter-theme/commit/da6b99f))
* **Features/Acf/OptionPages:** use correct casing for subpage filter name ([#254](https://github.com/flyntwp/flynt-starter-theme/issues/254)) ([57aed0e](https://github.com/flyntwp/flynt-starter-theme/commit/57aed0e))
* **Features/TinyMce:** correct styleformats in config ([#257](https://github.com/flyntwp/flynt-starter-theme/issues/257)) ([1fac210](https://github.com/flyntwp/flynt-starter-theme/commit/1fac210))


### Features

* **Features/TimberLoader:** convert images in ACF gallery field to Timber images ([#258](https://github.com/flyntwp/flynt-starter-theme/issues/258)) ([40c5daa](https://github.com/flyntwp/flynt-starter-theme/commit/40c5daa))


### BREAKING CHANGES

* **Features/TimberLoader:** anyone previously relying on the gallery field's default return values will
probably run into issues with this change



<a name="0.2.2"></a>
## [0.2.2](https://github.com/flyntwp/flynt-starter-theme/compare/v0.2.1...v0.2.2) (2017-08-24)


### Bug Fixes

* **Components/SliderMedia:** remove pointer-events on .slick-dots, so it doesn't overlap Youtube's controls (#245) ([45f9343](https://github.com/flyntwp/flynt-starter-theme/commit/45f9343))
* **Components/SliderMedia:** set slick-dots line-height to 0 (#243) ([92e7630](https://github.com/flyntwp/flynt-starter-theme/commit/92e7630))
* **Features/Acf:** add required hooks check to OptionPages::get() (#229) ([0f62245](https://github.com/flyntwp/flynt-starter-theme/commit/0f62245))
* **nodejs:** add compatibility for node 8 ([edb01eb](https://github.com/flyntwp/flynt-starter-theme/commit/edb01eb)), closes [flyntwp/flynt-cli#59](https://github.com/flyntwp/flynt-cli/issues/59)


### Features

* **Components/SliderMedia:** Add alt attribute for images (#247) ([aa63791](https://github.com/flyntwp/flynt-starter-theme/commit/aa63791))
* **Feature/ExternalScriptLoader:** Add GoogleMaps support (#236) ([cf5c83e](https://github.com/flyntwp/flynt-starter-theme/commit/cf5c83e))



<a name="0.2.1"></a>
## [0.2.1](https://github.com/flyntwp/flynt-starter-theme/compare/v0.2.0...v0.2.1) (2017-06-20)


### Bug Fixes

* **Components/ListPosts:** fix wrong case on css import in partials path (#226) ([f86a6f0](https://github.com/flyntwp/flynt-starter-theme/commit/f86a6f0)), closes [#226](https://github.com/flyntwp/flynt-starter-theme/issues/226)



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

* **lib/Bootstrap:** Renamed checkPlugin to checkRequiredPlugins; only used in the theme's functions.php, but still a public method name that changed.

* **Features/Acf/OptionPages:** Removed OptionPages::getOption and OptionPages::getOptions. Using OptionPages::get instead.



<a name="0.1.0"></a>
# 0.1.0 (2017-05-02)


## Initial Release
