const gulp = require('gulp'),
    gutil = require('gulp-util'),
    webpack = require('webpack'),
    webpackConfig = require('./webpack.config.js'),
    globby = require('globby'),
    del = require('del'),
    runSequence = require('run-sequence'),
    watch = require('gulp-watch'),
    browserSync = require('browser-sync'),
    stylus = require('gulp-stylus'),
    rupture = require('rupture'),
    path = require('path'),
    changed = require('gulp-changed'),
    rev = require('gulp-rev'),
    revNapkin = require('gulp-rev-napkin'),
    revReplace = require('gulp-rev-replace'),
    sourcemaps = require('gulp-sourcemaps')

const config = {
  copy: [
    './{Modules,assets}/**/*',
    '!./{Modules,assets}/**/*.{js,styl,sass,less}'
  ],
  stylus: [
    './{Modules,assets}/**/style.styl'
  ],
  webpack: {
  },
  php: [
    './**/*.php'
  ],
  dest: './dist'
}
config.rev = {
  src: config.dest + '/**/*.*',
  srcRevved: [
    config.dest + '/**/*.{js,css}',
    '!' + config.dest + '/style.css',
  ],
  srcStatic: config.dest + '/**/*.{html,php,pug}',
  assetSrc: [
    config.dest + '/**/*',
    '!' + config.dest + '/**/*+(css|js|json|html|php|pug|pot|md|htc|swf|xap)',
    '!' + config.dest + '/style.css',
    '!' + config.dest + '/screenshot.png',
    '!' + config.dest + '/favicon.ico',
    '!' + config.dest + '/favicon.png',
    '!' + config.dest + '/apple-touch-icon-180x180.png',
    '!' + config.dest + '/apple-touch-icon.png',
    '!' + config.dest + '/**/preview-desktop.jpg',
    '!' + config.dest + '/**/preview-mobile.jpg'
  ],
  revvedFileExtensions: ['.js', '.css'],
  staticFileExtensions: ['.html', '.php', '.pug']
}

config.webpack.entry = globby.sync('{Modules,assets}/**/script.js').reduce(function(output, entryPath) {
  output[entryPath.replace('/script.js', '')] = './' + entryPath
  return output;
}, {})

gulp.task('build', function (cb) {
  runSequence(
    'clean',
    ['copy', 'webpack:build'],
    'rev',
    cb
  )
});

gulp.task('webpack:build', function (callback) {
  config.webpack.production = true
  webpack(webpackConfig(config.webpack), webpackTask(callback));
});

function webpackTask (callback) {
  var initialCompile = false
  return function (err, stats) {
    if (err)
      throw new gutil.PluginError('webpack:build', err)
    browserSync.reload()
    gutil.log('[webpack:build] Completed\n' + stats.toString({
      assets: true,
      chunks: false,
      chunkModules: false,
      colors: true,
      hash: false,
      timings: false,
      version: false
    }))
    if(!initialCompile) {
      initialCompile = true
      callback()
    }
  }
}

gulp.task('webpack:watch', function (callback) {
  webpack(webpackConfig(config.webpack)).watch(null, webpackTask(callback));
});

gulp.task('default', function (cb) {
  runSequence(
    'clean',
    ['copy', 'stylus'],
    ['watch'],
    cb
  )
});

gulp.task('watch', ['webpack:watch', 'browserSync'], function (cb) {
  watch(config.copy, function() { gulp.start('copy')})//.on('change', browserSync.reload)
  watch(config.stylus, function() { gulp.start('stylus')})//.on('change', browserSync.reload)
  watch(config.php, function() { }).on('change', browserSync.reload)
})

gulp.task('stylus', function() {
  return gulp.src(config.stylus)
  .pipe(changed(config.dest))
  .pipe(sourcemaps.init())
  .pipe(stylus({
    use: [
      rupture()
    ],
    import: [path.resolve(__dirname, '../node_modules/jeet/styl/index.styl')]
  }))
  .pipe(sourcemaps.write({sourceRoot: '/app/themes/wp-starter-theme/'}))
  .pipe(gulp.dest(config.dest))
  .pipe(browserSync.stream())
})

gulp.task('browserSync', function () {
  return browserSync.init({
    proxy: 'wp-starter-boilerplate.dev',
    open: false,
    ghostMode: false,
  })
})

gulp.task('clean', function () {
  return del([
    `${config.dest}/**`
  ])
})

gulp.task('copy', function() {
  return gulp.src(config.copy)
  .pipe(changed(config.dest))
  .pipe(gulp.dest(config.dest))
  .pipe(browserSync.stream())
})

gulp.task('rev', function(cb) {
  return runSequence(
    // 1) Add md5 hashes to assets referenced by CSS and JS files
    'revAssets',
    // 2) Update asset references (images, fonts, etc) with reved filenames in compiled css + js
    'revUpdateReferences',
    // 3) Rev and compress CSS and JS files (this is done after assets, so that if a referenced asset hash changes, the parent hash will change as well
    'revRevvedFiles',
    // 4) Update asset references in HTML
    'revStaticFiles',
  cb)
})

// 1) Add md5 hashes to assets referenced by CSS and JS files
gulp.task('revAssets', function() {
  // Ignore files that may reference assets. We'll rev them next.
  return gulp.src(config.rev.assetSrc)
  .pipe(rev())
  .pipe(gulp.dest(config.dest))
  .pipe(revNapkin({verbose: false}))
  .pipe(rev.manifest(path.join(config.dest, 'rev-manifest.json'), {merge: true}))
  .pipe(gulp.dest(''))
})

// 2) Update asset references with reved filenames in compiled css + js
gulp.task('revUpdateReferences', function(){
  var manifest = gulp.src(path.join(config.dest, "rev-manifest.json"))

  return gulp.src(path.join(config.dest,'/**/**.{css,js}'))
  .pipe(revReplace({manifest: manifest}))
  .pipe(gulp.dest(config.dest))
})

// 3) Rev and compress CSS and JS files (this is done after assets, so that if a
//    referenced asset hash changes, the parent hash will change as well
gulp.task('revRevvedFiles', function(){
  return gulp.src(config.rev.srcRevved)
  .pipe(rev({
    replaceInExtensions: config.rev.revvedFileExtensions
  }))
  .pipe(gulp.dest(config.dest))
  .pipe(revNapkin({verbose: false}))
  .pipe(rev.manifest(path.join(config.dest, 'rev-manifest.json'), {merge: true}))
  .pipe(gulp.dest(''))
})

// 4) Update asset references in HTML
gulp.task('revStaticFiles', function(){
  var manifest = gulp.src(path.join(config.dest, "/rev-manifest.json"))
  return gulp.src(config.rev.srcStatic)
  .pipe(revReplace({
    manifest: manifest,
    replaceInExtensions: config.rev.staticFileExtensions
  }))
  .pipe(gulp.dest(path.join(config.dest)))
})
