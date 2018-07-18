const dest = './dist'
const host = 'flynt.test'

module.exports = {
  browserSync: {
    ghostMode: false,
    open: false,
    proxy: host,
    watchOptions: {
      ignoreInitial: true
    },
    files: ['dist/{Components,Features}/**/*.css'],
    injectChanges: true,
    reloadDebounce: 1000
  },
  copy: [
    './{Components,Features}/**/*',
    '!./{Components,Features}/**/*.{js,styl,sass,less}'
  ],
  dest: dest,
  rev: {
    src: dest + '/**/*.*',
    srcRevved: [
      dest + '/**/*.{js,css}',
      '!' + dest + '/style.css'
    ],
    srcStatic: dest + '/**/*.{html,php,twig}',
    assetSrc: [
      dest + '/**/*',
      '!' + dest + '/**/*+(css|js|json|html|php|twig|pot|md|htc|swf|xap)',
      '!' + dest + '/style.css',
      '!' + dest + '/screenshot.png',
      '!' + dest + '/favicon.ico',
      '!' + dest + '/favicon.png',
      '!' + dest + '/apple-touch-icon-180x180.png',
      '!' + dest + '/apple-touch-icon.png',
      '!' + dest + '/**/preview-desktop.jpg',
      '!' + dest + '/**/preview-mobile.jpg'
    ],
    revvedFileExtensions: ['.js', '.css'],
    staticFileExtensions: ['.html', '.php', '.twig']
  },
  sourcemaps: {
    sourceRoot: '/app/themes/flynt-starter-theme/'
  },
  stylus: [
    './{Components,Features}/**/*.styl',
    '!./{Components,Features}/**/_*.styl'
  ],
  watch: {
    stylus: './{Components,Features}/**/*.styl',
    php: './**/*.php',
    hardReloadOnStylFiles: ['Components/_variables.styl'],
    stylusPartials: {
      partialCssFilenamePrefix: '_',
      rootCssFilename: 'style.styl',
      stopSearchDirnames: ['Components', 'Features']
    }
  },
  webpack: {
    entry: [
      './{Components,Features}/**/{script,admin,auth}.js'
    ]
  },
  lint: {
    stylus: './{Components,Features}/**/*.styl',
    js: [
      './{Components,Features,gulpfile.js}/**/*.js'
    ],
    php: [
      './**/*.php',
      '!./dist/**/*.php',
      '!./node_modules/**/*.php'
    ],
    phpcs: {
      standard: 'phpcs.ruleset.xml',
      binaryPath: '../../../../vendor/bin/phpcs'
    }
  },
  replaceVersion: {
    wordpress: {
      files: './style.css',
      from: /Version: (.*)/gi,
      to: 'Version: '
    },
    php: {
      files: '!(node_modules|dist)/**/*.php',
      from: '%%NEXT_VERSION%%'
    }
  }
}
