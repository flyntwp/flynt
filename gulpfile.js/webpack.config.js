const webpack = require('webpack')
module.exports = function(config) {
  const output = {
    name: 'browser',
    output: {
      path: './dist',
      filename: '[name]/script.js',
      publicPath: '/',
      library: '[name]',
      libraryTarget: 'amd',
      umdNamedDefine: true,
    },
    module: {
      loaders: [
        {
          test: /\.js$/,
          exclude: /(node_modules|bower_components)/,
          loader: 'babel-loader',
          query: {
            // plugins: ['transform-es2015-modules-amd'],
            presets: ['es2015']
          }
        }
      ]
    },
    // externals: [
    //   function(context, request, callback) {
    //     // Every module prefixed with "global-" becomes external
    //     // "global-abc" -> abc
    //     // if(/^global-/.test(request))
    //     //   return callback(null, "var " + request.substr(7));
    //     callback();
    //   },
    // ]
    // plugins: [
    //   new webpack.DefinePlugin({
    //     'process.env': {
    //       'NODE_ENV': JSON.stringify('production')
    //     }
    //   }),
    //   new webpack.optimize.DedupePlugin(),
    //   new webpack.optimize.UglifyJsPlugin(),
    //   new webpack.optimize.AggressiveMergingPlugin()
    // ],
  }
  output.entry = config.entry
  return output
}
