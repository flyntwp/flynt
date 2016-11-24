const dest = './dist'
const host = 'wp-starter-boilerplate.dev'

// TODO add deploy task
module.exports = {
  browserSync: {
    ghostMode: false,
    open: false,
    proxy: host
  },
  copy: [
    './{Modules,assets}/**/*',
    '!./{Modules,assets}/**/*.{js,styl,sass,less}'
  ],
  dest: dest,
  php: [
    './**/*.php'
  ],
  rev: {
    src: dest + '/**/*.*',
    srcRevved: [
      dest + '/**/*.{js,css}',
      '!' + dest + '/style.css'
    ],
    srcStatic: dest + '/**/*.{html,php,pug}',
    assetSrc: [
      dest + '/**/*',
      '!' + dest + '/**/*+(css|js|json|html|php|pug|pot|md|htc|swf|xap)',
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
    staticFileExtensions: ['.html', '.php', '.pug']
  },
  sourcemaps: {
    sourceRoot: '/app/themes/wp-starter-theme/'
  },
  stylus: [
    './{Modules,assets}/**/style.styl'
  ],
  webpack: {
    entry: {
      'Modules': './Modules/script.js'
    }
  },
  lint: {
    stylus: './{Modules,assets}/**/*.styl',
    js: [
      './{Modules,assets,gulpfile.js}/**/*.js'
    ],
    php: [
      './**/*.php',
      '!./dist/**/*.php',
      '!./node_modules/**/*.php'
    ],
    phpcs: {
      standard: 'phpcs.ruleset.xml'
    }
  }
}
