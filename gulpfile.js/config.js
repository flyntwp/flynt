const dest = './dist'
const host = 'https://flynt-starter-theme.local.blee.ch'

module.exports = {
  browserSync: {
    ghostMode: false,
    open: false,
    proxy: host,
    watchOptions: {
      ignoreInitial: true
    },
    files: ['dist/{Components,Features,assets}/**/*.css'],
    injectChanges: true,
    reloadDebounce: 1000
  },
  copy: [
    './{Components,Features,assets}/**/*',
    '!./{Components,Features,assets}/**/*.{js,styl,scss,less}'
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
  sass: [
    './{Components,Features,assets}/**/*.scss',
    '!./{Components,Features,assets}/**/_*.scss'
  ],
  watch: {
    sass: ['./{Components,Features,assets}/**/*.scss'],
    php: [
      './**/*.php',
      '!./{Components,Features,assets}/**/*.php'
    ],
    hardReloadOnSassFiles: ['Components/_variables.scss'],
    sassPartials: {
      partialCssFilenamePrefix: '_',
      rootCssFilename: 'style.scss',
      stopSearchDirnames: ['Components', 'Features']
    }
  },
  webpack: {
    entry: [
      './{Components,Features,assets}/**/{script,admin,auth}.js'
    ]
  },
  lint: {
    sass: ['./{Components,Features,assets}/**/*.scss'],
    js: ['./{Components,Features,assets,gulpfile.js}/**/*.js'],
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
