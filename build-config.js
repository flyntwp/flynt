const domain = 'flynt-components.local.blee.ch'
const dest = './dist'

const host = `https://${domain}`

const entries = {
  'assets/main': './assets/main.js',
  'assets/admin': './assets/admin.js'
}

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
