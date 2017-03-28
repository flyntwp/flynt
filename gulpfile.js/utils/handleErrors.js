var notify = require('gulp-notify')

module.exports = function () {
  var args = Array.prototype.slice.call(arguments)

  // Send error to notification center with gulp-notify
  notify.onError({
    title: 'Flynt Compile Failed',
    subtitle: '<%= error.plugin %>: <%= error.name %>',
    message: '<%= error.message %>'
  }).apply(this, args)

  // Keep gulp from hanging on this task
  if (typeof this.emit === 'function') {
    this.emit('end')
  }
}
