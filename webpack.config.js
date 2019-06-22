const path = require('path')
const webpack = require('webpack')
const TerserPlugin = require('terser-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const globImporter = require('node-sass-glob-importer')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin')
const config = require('./build-config').webpack

const production = process.env.NODE_ENV === 'production'

function buildBabelConfig (legacy = true) {
  const babelQuery = {
    presets: [
      ['@babel/preset-env', {
        useBuiltIns: 'usage',
        corejs: 'core-js@3',
        targets: legacy ? undefined : {
          esmodules: true
        }
      }]
    ],
    plugins: ['@babel/plugin-transform-runtime']
  }
  return babelQuery
}

// config.production = true
function buildWebpackConfig (babelQuery) {
  const webpackConfig = {
    mode: production ? 'production' : 'development',
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
            MiniCssExtractPlugin.loader,
            'css-loader'
          ]
        },
        {
          test: /\.scss$/,
          use: [
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
      new FriendlyErrorsWebpackPlugin({
        clearConsole: false
      })
    ],
    optimization: {
      splitChunks: {
        cacheGroups: {
          vendors: false,
          default: false
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
      new TerserPlugin({
        sourceMap: false,
        cache: true,
        parallel: true
      }),
      new OptimizeCSSAssetsPlugin({})
    ]
  } else {
    webpackConfig.plugins.push(
      new webpack.DefinePlugin({
        PRODUCTION: JSON.stringify(false),
        'process.env': {
          'NODE_ENV': JSON.stringify('development')
        }
      })
    )
  }
  return webpackConfig
}

function buildEntryConfig (entry, legacy = true) {
  const webpackConfig = buildWebpackConfig(buildBabelConfig(legacy))
  const basename = `${entry}${legacy ? '_legacy' : ''}`
  return {
    ...webpackConfig,
    entry: config.entry[entry],
    name: config.entry[entry],
    output: {
      ...webpackConfig.output,
      filename: `${basename}.js`
    },
    plugins: [
      ...webpackConfig.plugins,
      new MiniCssExtractPlugin({
        // Options similar to the same options in webpackOptions.output
        // both options are optional
        filename: `${basename}.css`,
        chunkFilename: `${basename}.css`
      })
    ]
  }
}

const multiConfig = []
Object.keys(config.entry).forEach(entry => {
  multiConfig.push(buildEntryConfig(entry, true))
  multiConfig.push(buildEntryConfig(entry, false))
})

module.exports = multiConfig
