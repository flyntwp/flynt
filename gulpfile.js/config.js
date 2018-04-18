const dest = './dist'
const host = 'flynt.test'

module.exports = {
  browserSync: {
    ghostMode: false,
    open: false,
    proxy: host
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
    php: './**/*.php'
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
      '!./node_modules/**/*.php',
      '!./bower_components/**/*.php'
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
      files: '!(node_modules|bower_components|dist)/**/*.php',
      from: '%%NEXT_VERSION%%'
    }
  }
}
