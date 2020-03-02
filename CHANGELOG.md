# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

### [1.2.1](https://github.com/flyntwp/flynt/compare/v1.2.0...v1.2.1) (2020-03-02)


### Bug Fixes

* **build:** update and validate composer.json on release ([0b44209](https://github.com/flyntwp/flynt/commit/0b44209e3ac71ab32f8af07e8eab5f72d8be9918))

## [1.2.0](https://github.com/flyntwp/flynt/compare/v1.1.1...v1.2.0) (2020-02-26)


### Features

* **BaseStyle:** add print styles ([fc37b44](https://github.com/flyntwp/flynt/commit/fc37b440bd4c0503ad29814e4c4419734fcc1838)), closes [#236](https://github.com/flyntwp/flynt/issues/236)
* **BaseStyle:** implement sticky footer concept ([19918b3](https://github.com/flyntwp/flynt/commit/19918b3caff4208ad40c0194e96ee2f32302874a)), closes [#227](https://github.com/flyntwp/flynt/issues/227)
* **HTML5:** remove type for script and link tags  ([9f08d95](https://github.com/flyntwp/flynt/commit/9f08d95b8f71a4d94be053189dbf3541e7fe3f48)), closes [#210](https://github.com/flyntwp/flynt/issues/210)
* **TimberDynamicResize:** always store in dynamic folder ([7e0d931](https://github.com/flyntwp/flynt/commit/7e0d93138465bb305e31e719d6d3fa184e4deb27))
* **TimberDynamicResize:** change db structure ([d85f4e8](https://github.com/flyntwp/flynt/commit/d85f4e8605a73999a6ed0099d53ed6a6d3efff8f))
* **TimberDynamicResize:** clean up filters ([9ed45c0](https://github.com/flyntwp/flynt/commit/9ed45c0c4f276ea60fadf92aaebf9810a4c714dc))
* **TimberDynamicResize:** merge header instead of append ([631222b](https://github.com/flyntwp/flynt/commit/631222ba46509a68b3d21ab87396bbcb8a15df0f)), closes [#224](https://github.com/flyntwp/flynt/issues/224)
* **TimberDynamicResize:** use wp functions for 404 and redirect ([b50dc00](https://github.com/flyntwp/flynt/commit/b50dc00dda09ce77482523f53f6a5a1cb5bfdfce))
* **TimberDynamicResize:** use wp rewrites ([0ede66b](https://github.com/flyntwp/flynt/commit/0ede66b2653b7644cc6ad94a46fc40f2f5a79cce))


### Bug Fixes

* **assets:** only import script.js and admin.js ([c9d1c25](https://github.com/flyntwp/flynt/commit/c9d1c25fef7ee58737341cdbcda9b5e7a367438a))
* **BaseStyle:** change Reset Theme headline from h2 to h3 ([e29813e](https://github.com/flyntwp/flynt/commit/e29813e6c80f3991aa029af1ef5ffe4269ce2836))
* **Oembed:** check if $iframeTagHtml exists ([61debe5](https://github.com/flyntwp/flynt/commit/61debe5ecc716ab7d3473ed7d9c4dbb815d38129))
* **theContentFix:** don't add shortcode to custom css ([43272e4](https://github.com/flyntwp/flynt/commit/43272e4728a790937d2a00f96a05fadef3c8359b))

### [1.1.1](https://github.com/flyntwp/flynt/compare/v1.1.0...v1.1.1) (2019-11-29)


### Bug Fixes

* **AdminComponentScreenshots:** execute on document ready ([aa93a59](https://github.com/flyntwp/flynt/commit/aa93a59699647119072c4f5b109cd02b0dc8acc7))
* **publicPath:** pass via wp_localize_data ([bfb2435](https://github.com/flyntwp/flynt/commit/bfb2435cc13e3045a7e34a5c34c9a5185156d29d))
* **theContentFix:** correctly call in_array ([fe5039f](https://github.com/flyntwp/flynt/commit/fe5039fe6bc85644f1e7b471040d549116a39a13))

## [1.1.0](https://github.com/flyntwp/flynt/compare/v1.0.0...v1.1.0) (2019-11-28)


### Features

* **DynamicResize:** add routes wordpress natively ([85c29cf](https://github.com/flyntwp/flynt/commit/85c29cf092c6a77db58526c63e8795154e441a25))
* **FeatherIcons:** load from local server ([5a70341](https://github.com/flyntwp/flynt/commit/5a703418e635a022c8ae4c4096c339b9feedd54d))
* **Fonts:** load google fonts from local server ([11ad098](https://github.com/flyntwp/flynt/commit/11ad09812dd1cb0f707b6e5a8b89ff9a4b4bbbcd))
* **ScriptLoader:** add async/defer options ([b735436](https://github.com/flyntwp/flynt/commit/b735436fd72f8e788b583842fa810dd3923d1db4))


### Bug Fixes

* **BaseStyle:** correct query_vars check ([051c81a](https://github.com/flyntwp/flynt/commit/051c81a73a04a03206b11418b64eb56b3851b6e5))
* **BaseStyle:** prevent url segments after first and simplified rewrite rule ([950546e](https://github.com/flyntwp/flynt/commit/950546e8e325cc24f9025a43e3fd059bcab862c3))
* **BaseStyle:** replaced custom noindex code with wordpress action ([676235a](https://github.com/flyntwp/flynt/commit/676235a50f87b3d911a8a8ec60ad7dde72d8e60f))
* **BaseStyle:** use custom document title, instead of archive title ([5a0fd5b](https://github.com/flyntwp/flynt/commit/5a0fd5b3a7f80e69f3b703f1cc5449c293eb8152))
* **BaseStyle:** vertically center select input text in Firefox ([4b51d00](https://github.com/flyntwp/flynt/commit/4b51d0015cf134b3f87a8abbafc6a8f02be895bc)), closes [#185](https://github.com/flyntwp/flynt/issues/185)
* **BlockPostFooter:** prevent overflowing author info (IE11) ([ac65669](https://github.com/flyntwp/flynt/commit/ac6566915cbe66f6d4872d3729d478ddf011ebe5))
* **FeatureGoogleAnalytics:** Fixed boolean logic and window.$ ([26a8e5a](https://github.com/flyntwp/flynt/commit/26a8e5a5ed25b0bdc29f3211a08e9a5db1cac771))
* **GoogleAnalytics:** minor improvements ([31a753c](https://github.com/flyntwp/flynt/commit/31a753cacd0f8583117b4c0f4d047a91e7a259f2))
* **GridPostsArchive:** remove abandoned p-tag and close unclosed div ([6c11155](https://github.com/flyntwp/flynt/commit/6c11155eb2402d5a6a0ccc2667958ba2dd34af8d))
* **gulpfile.js:** replaceVersion path to package.json couldn't be found ([e36085b](https://github.com/flyntwp/flynt/commit/e36085b959d0561e5e49fe550eba9234de1826c9))
* **ListComponents:** prevent stretched screenshots (IE11) ([26febd4](https://github.com/flyntwp/flynt/commit/26febd4c52a3b192f183504dd79e0dd54496758a))
* **ListSearchResults:** remove min attribute on search input that is not allowed by spec ([7da38b4](https://github.com/flyntwp/flynt/commit/7da38b45f5b83a8b789d565b8ce005ca6edc13cf))
* **mixins.scss:** adjust font-face base path ([9b7bdec](https://github.com/flyntwp/flynt/commit/9b7bdecc0d92d0c8d5edb66debd2442d03426c2c))
* **single.twig:** prevent invalid blog post footer markup ([39fa4fa](https://github.com/flyntwp/flynt/commit/39fa4fa31f21e5f44ec6340b36784a2c8a479211))
* **theContentFix:** replace shortcode if post id changed ([92b4cfc](https://github.com/flyntwp/flynt/commit/92b4cfc326947c5964182e7b5bf42bde765ef56a))
* **theme:** disable big image size threshold ([283f072](https://github.com/flyntwp/flynt/commit/283f072e8c0db57f37417adf86fa623329d68cb0))
* **webpack:** set publicPath dynamically ([265c935](https://github.com/flyntwp/flynt/commit/265c935e6d8a81fdab6513882ce1f5a60ab6348f))
