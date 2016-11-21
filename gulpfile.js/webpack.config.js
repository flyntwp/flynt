const webpack = require('webpack')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const rupture = require('rupture')

module.exports = function(config) {
  const babelQuery = {
    // plugins: ['transform-es2015-modules-amd'],
    presets: [
      ['es2015', {loose: true}]
    ],
    plugins: [
      'transform-class-properties',
      [
        "babel-plugin-transform-builtin-extend", {
          globals: ["Error", "Array", "Object"],
          approximate: true
        }
      ]
    ],
  }
  const output = {
    name: 'browser',
    output: {
      path: './dist',
      filename: '[name]/script.js',
      publicPath: '/',
      // library: '[name]',
      // libraryTarget: 'amd',
      // umdNamedDefine: true,
    },
    devtool: config.production ? 'source-map' : 'eval-source-map',
    module: {
      loaders: [
        {
          test: /\.js$/,
          exclude: /(node_modules|bower_components)/,
          loader: 'babel-loader',
          query: babelQuery
        // }, {
        //   test: /\.styl$/,
        //   loader: 'style-loader!css-loader!stylus-loader'
        }
      ]
    },
    resolveLoader: {
      alias: {
        'with-babel': `babel-loader?${JSON.stringify(babelQuery)}`,
      }
    },
    stylus: {
      use: [
        rupture()
      ],
      import: ['~jeet/styl/index.styl']
    },
    // plugins: [
    //   new BrowserSyncPlugin({
    //     // browse to http://localhost:3000/ during development,
    //     // ./public directory is being served
    //     proxy: 'wp-starter-boilerplate.dev',
    //     open: false,
    //     ghostMode: false,
    //   })
    // ]
    // externals: [
    //   function(context, request, callback) {
    //     // Every module prefixed with "global-" becomes external
    //     // "global-abc" -> abc
    //     // if(/^global-/.test(request))
    //     //   return callback(null, "var " + request.substr(7));
    //     callback();
    //   },
    // ]
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
