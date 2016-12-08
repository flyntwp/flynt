import 'file-loader?name=vendor/draggabilly.js!draggabilly/dist/draggabilly.pkgd'
const $ = jQuery

// admin
if ($('body.wp-admin').length) {
  require('./admin')
} else if ($('html.logged-in').length) {
  // front-end logged in
  require('./auth')
}
