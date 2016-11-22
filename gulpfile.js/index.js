/*
  gulpfile.js
  ===========
  Rather than manage one giant configuration file responsible
  for creating multiple tasks, each task has been broken out into
  its own file in gulp/tasks. Any files in that directory get
  automatically required below.

  To add a new task, simply add a new task file that directory.
  gulp/tasks/default.js specifies the default set of tasks to run
  when you run `gulp`.
*/

const requireDir = require('require-dir')

// Require configs and all tasks in gulp/tasks, including subfolders
const config = require('./config')
const webpackConfig = require('./webpack.config')
const tasks = requireDir('./tasks', { recurse: true })

function resolveTasks(tasks) {
  for (task in tasks) {
    const fn = tasks[task]
    if (typeof fn !== 'function') {
      resolveTasks(fn)
      continue
    }
    if (task === 'webpack') {
      fn(webpackConfig, config)
    } else {
      fn(config)
    }
  }
}

resolveTasks(tasks)
