const gulp = require('gulp'),
    gutil = require('gulp-util'),
    webpack = require('webpack'),
    webpackConfig = require('./webpack.config.js'),
    globby = require('globby')
    del = require('del')
    runSequence = require('run-sequence');

const config = {
  copy: [
    './{Modules,assets}/**/*',
    '!./{Modules,assets}/**/*.{js,styl,sass,less}'
  ],
  webpack: {
  },
  dest: './dist'
}

config.webpack.entry = globby.sync('{Modules,assets}/**/script.js').reduce(function(output, entryPath) {
  output[entryPath.replace('/script.js', '')] = './' + entryPath
  return output;
}, {})

console.log(config)

gulp.task('build', function (cb) {
  runSequence(
    'clean',
    ['copy', 'webpack:build']
  )
});

gulp.task('webpack:build', function (callback) {
    webpack(webpackConfig(config.webpack), function (err, stats) {
        if (err)
            throw new gutil.PluginError('webpack:build', err);
        gutil.log('[webpack:build] Completed\n' + stats.toString({
            assets: true,
            chunks: false,
            chunkModules: false,
            colors: true,
            hash: false,
            timings: false,
            version: false
        }));
        callback();
    });
});

gulp.task('clean', function () {
  return del([
    `${config.dest}/**`
  ])
})

gulp.task('copy', function() {
  return gulp.src(config.copy)
  .pipe(gulp.dest(config.dest))
})
