const path = require('path')
const webpack = require('webpack')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const globImporter = require('node-sass-glob-importer')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin')
const config = require('./build-config').webpack

const production = process.env.NODE_ENV === 'production'

const babelQuery = {
  presets: [
    ['@babel/preset-env', {
      useBuiltIns: 'usage'
    }]
  ]
}

if (!production) {
  Object.keys(config.entry).forEach(function (entry) {
    config.entry[entry] = [
      'webpack-hot-middleware/client?reload=true&noInfo=true',
      config.entry[entry]
    ]
  })
}

// config.production = true
const webpackConfig = {
  mode: production ? 'production' : 'development',
  name: 'browser',
  entry: config.entry,
  output: {
    path: path.join(__dirname, 'dist'),
    publicPath: config.publicPath
  },
  devtool: production ? false : 'inline-source-map',
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
          'css-hot-loader',
          MiniCssExtractPlugin.loader,
          'css-loader'
        ]
      },
      {
        test: /\.scss$/,
        use: [
          'css-hot-loader',
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              url: false,
              import: false
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              plugins: [
                require('autoprefixer')()
              ]
            }
          },
          {
            loader: 'sass-loader',
            options: {
              importer: globImporter()
            }
          }
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
    new webpack.LoaderOptionsPlugin({
      debug: !config.production
    }),
    new CopyWebpackPlugin(config.copy),
    new MiniCssExtractPlugin({
      // Options similar to the same options in webpackOptions.output
      // both options are optional
      filename: '[name].css',
      chunkFilename: '[name].css',
      hot: true
    }),
    new FriendlyErrorsWebpackPlugin({
      clearConsole: false
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
            return chunks[0].name === 'assets/main' && (module.context || '').match(/[\\/]node_modules[\\/]/)
          },
          chunks: 'all',
          name: 'vendor/main',
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
webpackConfig.plugins = webpackConfig.plugins || []
if (production) {
  webpackConfig.plugins.push(
    new webpack.DefinePlugin({
      PRODUCTION: JSON.stringify(true),
      'process.env': {
        'NODE_ENV': JSON.stringify('production')
      }
    })
  )
  webpackConfig.plugins.push(new webpack.optimize.AggressiveMergingPlugin())
  webpackConfig.optimization.minimizer = [
    new UglifyJsPlugin({
      sourceMap: false,
      cache: true,
      parallel: true
    }),
    new OptimizeCSSAssetsPlugin({})
  ]
} else {
  webpackConfig.plugins.push(new webpack.HotModuleReplacementPlugin())
  webpackConfig.plugins.push(
    new webpack.DefinePlugin({
      PRODUCTION: JSON.stringify(false),
      'process.env': {
        'NODE_ENV': JSON.stringify('development')
      }
    })
  )
}

module.exports = webpackConfig
