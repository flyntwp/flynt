# Changelog

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

## [1.4.0](https://github.com/flyntwp/flynt/compare/v1.3.0...v1.4.0) (2020-10-21)


### Features

* **shortcodes, NavigationFooter:** add global shortcodes and examples for dynamic copyright notices ([#297](https://github.com/flyntwp/flynt/issues/297)) ([00f9f6b](https://github.com/flyntwp/flynt/commit/00f9f6b754a6df41f31b3396ad97884e85f1172d))
* **theme:** use wp_get_environment_type for WP_ENV ([#298](https://github.com/flyntwp/flynt/issues/298)) ([5bf90db](https://github.com/flyntwp/flynt/commit/5bf90dbd26a51063f60d0a6af68ac800fca41555))


### Bug Fixes

* **SliderImages:** add Number polyfill to fix Swiper v6 in IE ([#304](https://github.com/flyntwp/flynt/issues/304)) ([72e2be9](https://github.com/flyntwp/flynt/commit/72e2be9307124c57e5a488beba968afd50d54498))
* **theme:** force visuallyHidden styles ([#301](https://github.com/flyntwp/flynt/issues/301)) ([d0e7645](https://github.com/flyntwp/flynt/commit/d0e76454a30c678f4af2e1938c468692f9373652))
* **theme:** rename skiplink text ([#307](https://github.com/flyntwp/flynt/issues/307)) ([f82743d](https://github.com/flyntwp/flynt/commit/f82743dfa7573e7cf54b78bee73349a2eb9e780d))
* **TimberDynamicResize:** convert path with backslash to slash for uploads basedir just as get_home_path() ([#299](https://github.com/flyntwp/flynt/issues/299)) ([789098e](https://github.com/flyntwp/flynt/commit/789098e51c677b504058fbffb0e7b5a66c8f54b5))


### Other

* **php:** adjust several argument definition  ([b7f64f9](https://github.com/flyntwp/flynt/commit/b7f64f9ef71a48beb08f147c89e70ae123c81c53))
* **swiper:** only import needed components ([#319](https://github.com/flyntwp/flynt/issues/319)) ([ff82ebd](https://github.com/flyntwp/flynt/commit/ff82ebdb70683504f18b85fa47fd2d5583cb4523))

## [1.3.0](https://github.com/flyntwp/flynt/compare/v1.2.1...v1.3.0) (2020-08-13)


### Features

* **BlockVideoOembed:** add multiple size options ([a26a933](https://github.com/flyntwp/flynt/commit/a26a933ce6b3b9b1abab732e551fbe1dc8fcb09c))
* **Components:** Accessibility Improvements ([1ebc27b](https://github.com/flyntwp/flynt/commit/1ebc27b386ac86398d8cc7ce2253388252eeb9bb))
* **ExternalScriptLoader:** remove ([8c54251](https://github.com/flyntwp/flynt/commit/8c542514e0fcfbad88c389f4863199db2a9a937b)), closes [#283](https://github.com/flyntwp/flynt/issues/283)
* **FormPasswordProtection, post, GridPostsArchive:** add missing titles in favor of accessibility ([4891096](https://github.com/flyntwp/flynt/commit/489109652e168d9936ac632b2b78f7c136b309ff))
* **NavigationMain:** allow changing the logo via the customizer ([4e84112](https://github.com/flyntwp/flynt/commit/4e8411260f5b5fdd2d13bbee6e5b0066578d61c5))
* **pageComponents:** add page components to all pages and post types, but posts ([f218164](https://github.com/flyntwp/flynt/commit/f218164d3c470a6976656b72f121570939c177df))
* **RemoveEditor:** dequeue Gutenberg styles ([3321873](https://github.com/flyntwp/flynt/commit/3321873109cba56fb66c01a365609a6521bacb37)), closes [#261](https://github.com/flyntwp/flynt/issues/261)
* **theme:** add heading format classes ([6f357ce](https://github.com/flyntwp/flynt/commit/6f357ceadd1d529916b39baae6d622ba25b4d018))
* **TimberDynamicResize:** finetune functionality, add global options ([40e2f64](https://github.com/flyntwp/flynt/commit/40e2f645f9c294d989e9269958ba3e0f9dbb60eb))
* **translations:** make component labels translatable ([4524cab](https://github.com/flyntwp/flynt/commit/4524cabdf0ad83d35fb711d580ce4359b4bc1154))


### Bug Fixes

* **baseStyle:** add missing parenthesis to data:image causing issues in IE ([071970d](https://github.com/flyntwp/flynt/commit/071970dd458dbef96628e7f092ab625d5a2fbeb8))
* **BlockVideoOembed:** substitute deprecated selector ([#244](https://github.com/flyntwp/flynt/issues/244)) ([0338027](https://github.com/flyntwp/flynt/commit/0338027dca6ed54dd96128c8e720ab6299ef30dd))
* **ComponentLogServer:** check if WP_ENV is defined ([04299f9](https://github.com/flyntwp/flynt/commit/04299f9253dc7ee9b92bf4600e7017c53bd66da6)), closes [#247](https://github.com/flyntwp/flynt/issues/247)
* **FeatureAdminComponentScreenshots:** fix preview image not being full width ([7a68830](https://github.com/flyntwp/flynt/commit/7a688307364bd23963b27764824d2194a3a9e50f))
* **MimeTypes:** allow png uploads, remove max upload size, update instructions ([33f0247](https://github.com/flyntwp/flynt/commit/33f0247241d27bc1650da348dbb51530076500f7))

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

## [1.0.0](https://github.com/flyntwp/flynt/releases/tag/v1.0.0) (2019-11-28)

Initial release
