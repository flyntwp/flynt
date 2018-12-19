const path = require('path')
const webpack = require('webpack')
const HardSourcePlugin = require('hard-source-webpack-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')

module.exports = function (config) {
  const babelQuery = {
    presets: [
      ['@babel/preset-env', {
        useBuiltIns: 'entry'
      }]
    ]
  }
  const output = {
    mode: config.production ? 'production' : 'development',
    name: 'browser',
    entry: config.entry,
    output: {
      path: path.join(__dirname, '../dist'),
      publicPath: 'http://localhost:3000/'
    },
    devtool: config.production ? false : 'inline-source-map',
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /(node_modules)/,
          use: [{
            loader: 'babel-loader',
            options: babelQuery
          }]
        }
      ]
    },
    resolve: {
      modules: [
        'node_modules'
      ],
      descriptionFiles: [
        'package.json'
      ],
      mainFields: ['main', 'browser']
    },
    resolveLoader: {
      alias: {
        'with-babel': `babel-loader?${JSON.stringify(babelQuery)}`
      }
    },
    plugins: [
      new webpack.LoaderOptionsPlugin({
        debug: !config.production
      }),
      new HardSourcePlugin()
    ],
    externals: {
      jquery: 'jQuery'
    }
  }
  if (config.production) {
    output.plugins = output.plugins || []
    output.plugins.push(
      new webpack.DefinePlugin({
        PRODUCTION: JSON.stringify(true),
        'process.env': {
          'NODE_ENV': JSON.stringify('production')
        }
      })
    )
    output.plugins.push(new webpack.optimize.AggressiveMergingPlugin())
    output.optimization = {
      minimizer: [
        new UglifyJsPlugin({
          sourceMap: false,
          cache: true,
          parallel: true
        })
      ]
    }
  }
  return output
}

function removeExtension (filePath) {
  return path.join(
    path.dirname(filePath),
    path.basename(filePath, path.extname(filePath))
  )
}
