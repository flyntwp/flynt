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
    injectChanges: true,
    reloadDebounce: 1000
  },
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
  webpack: {
    entry: {
      'assets/script': './assets/script.js',
      'assets/admin': './assets/admin.js',
      'assets/auth': './assets/auth.js'
    },
    copy: [{
      from: './{Components,Features,assets}/**/*',
      to: './',
      ignore: ['*.js', '*.scss']
    }],
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
