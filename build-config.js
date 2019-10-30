const host = 'https://flynt-components.local.blee.ch'
const themeName = 'flynt-components'
const dest = './dist'

const path = require('path')

module.exports = {
  webpack: {
    publicPath: path.join(`/app/themes/${themeName}/`, dest, '/'),
    entry: {
      'assets/main': './assets/main.js',
      'assets/admin': './assets/admin.js'
    },
    copy: [
      {
        from: './{Components,assets}/**/*',
        to: './',
        ignore: ['*.js', '*.scss', '*.php', '*.twig']
      }
    ]
  },
  browserSync: {
    ghostMode: false,
    open: false,
    proxy: {
      target: host,
      ws: false
    },
    watchOptions: {
      ignoreInitial: true
    },
    injectChanges: true,
    reloadDebounce: 1000,
    ui: false,
    files: [
      '*.php',
      'templates/**/*',
      'lib/**/*',
      'inc/**/*',
      './Components/**/*.{php,twig}'
    ],
    watch: true,
    https: true
  },
  webpackDevMiddleware: {
    stats: false,
    writeToDisk: true
  },
  gulp: {
    dest: dest,
    rev: {
      src: dest + '/**/*.*',
      srcRevved: [dest + '/**/*.{js,css}', '!' + dest + '/style.css'],
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
        '!' + dest + '/**/screenshot.png'
      ],
      revvedFileExtensions: ['.js', '.css'],
      staticFileExtensions: ['.html', '.php', '.twig']
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
}
