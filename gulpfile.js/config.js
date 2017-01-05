const dest = './dist'
const host = 'flynt.dev'

module.exports = {
  browserSync: {
    ghostMode: false,
    open: false,
    proxy: host
  },
  copy: [
    './{Components,assets}/**/*',
    '!./{Components,assets}/**/*.{js,styl,sass,less}'
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
    sourceRoot: '/app/themes/flynt-theme/'
  },
  stylus: [
    './{Components,assets}/**/style.styl'
  ],
  watch: {
    stylus: './{Components,assets}/**/*.styl',
    php: './**/*.php'
  },
  webpack: {
    entry: {
      'Components': './Components/script.js'
    }
  },
  lint: {
    stylus: './{Components,assets}/**/*.styl',
    js: [
      './{Components,assets,gulpfile.js}/**/*.js'
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
  }
}
