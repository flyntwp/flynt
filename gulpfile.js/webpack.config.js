const webpack = require('webpack')
const rupture = require('rupture')

module.exports = function (config) {
  const babelQuery = {
    presets: [
      ['es2015', {loose: true}]
    ],
    plugins: [
      'transform-class-properties',
      [
        'babel-plugin-transform-builtin-extend', {
          globals: ['Error', 'Array', 'Object'],
          approximate: true
        }
      ]
    ]
  }
  const output = {
    debug: !config.production,
    name: 'browser',
    output: {
      path: './dist',
      filename: '[name]/script.js',
      publicPath: 'http://localhost:3000/'
    },
    devtool: config.production ? 'source-map' : 'inline-source-map',
    module: {
      loaders: [
        {
          test: /\.js$/,
          exclude: /(node_modules|bower_components)/,
          loader: 'babel-loader',
          query: babelQuery
        }
      ]
    },
    resolveLoader: {
      alias: {
        'with-babel': `babel-loader?${JSON.stringify(babelQuery)}`
      }
    },
    stylus: {
      use: [
        rupture()
      ],
      import: ['~jeet/styl/index.styl']
    }
  }
  if (config.production) {
    output.plugins = output.plugins || []
    output.plugins.push(
      new webpack.DefinePlugin({
        'process.env': {
          'NODE_ENV': JSON.stringify('production')
        }
      })
    )
    output.plugins.push(new webpack.optimize.DedupePlugin())
    output.plugins.push(new webpack.optimize.UglifyJsPlugin({
      sourceMap: false
    }))
    output.plugins.push(new webpack.optimize.AggressiveMergingPlugin())
  }
  output.entry = config.entry
  return output
}
