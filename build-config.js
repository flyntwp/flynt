const domain = 'flynt.test'
const dest = './dist'

const host = `https://${domain}`

const entries = [
  './assets/main.js',
  './assets/main.scss',
  './assets/admin.js',
  './assets/admin.scss',
  './assets/tinyMce.scss'
]

const watchFiles = [
  '*.php',
  'templates/**/*',
  'lib/**/*',
  'inc/**/*',
  './Components/**/*.{php,twig}'
]

module.exports = {
  dest,
  host,
  domain,
  entries,
  watchFiles
}
