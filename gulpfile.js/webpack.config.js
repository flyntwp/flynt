const path = require('path')
const webpack = require('webpack')
const HardSourcePlugin = require('hard-source-webpack-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')

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
        },
        {
          test: /\.css$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader'
          ]
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
      new HardSourcePlugin(),
      new webpack.LoaderOptionsPlugin({
        debug: !config.production
      }),
      new MiniCssExtractPlugin({
        // Options similar to the same options in webpackOptions.output
        // both options are optional
        filename: '[name].css',
        chunkFilename: '[name].css'
      })
    ],
    externals: {
      jquery: 'jQuery'
    },
    optimization: {
      splitChunks: {
        cacheGroups: {
          vendors: false,
          default: false,
          vendor: {
            test (module, chunks) {
              return chunks[0].name === 'assets/script' && (module.context || '').match(/[\\/]node_modules[\\/]/)
            },
            chunks: 'all',
            name: 'vendor/script',
            priority: 1
          },
          vendorAdmin: {
            test (module, chunks) {
              return chunks[0].name === 'assets/admin' && (module.context || '').match(/[\\/]node_modules[\\/]/)
            },
            chunks: 'all',
            name: 'vendor/admin',
            priority: 1
          },
          vendorAuth: {
            test (module, chunks) {
              return chunks[0].name === 'assets/auth' && (module.context || '').match(/[\\/]node_modules[\\/]/)
            },
            chunks: 'all',
            name: 'vendor/auth',
            priority: 1
          }
        }
      }
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
    output.optimization.minimizer = [
      new UglifyJsPlugin({
        sourceMap: false,
        cache: true,
        parallel: true
      }),
      new OptimizeCSSAssetsPlugin({})
    ]
  }
  return output
}
