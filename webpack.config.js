const path = require('path')
const webpack = require('webpack')
const TerserPlugin = require('terser-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin')
const globImporter = require('node-sass-glob-importer')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const FriendlyErrorsWebpackPlugin = require('@soda/friendly-errors-webpack-plugin')
const config = require('./build-config').webpack

const production = process.env.NODE_ENV === 'production'

const babelQuery = {
  presets: [
    ['@babel/preset-env', {
      useBuiltIns: 'usage',
      corejs: 'core-js@3'
    }]
  ],
  plugins: [
    '@babel/plugin-transform-runtime',
    'babel-plugin-smart-webpack-import'
  ]
}

// config.production = true
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
              url: false
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  require('autoprefixer')
                ]
              }
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sassOptions: {
                importer: globImporter()
              }
            }
          }
        ]
      }
    ]
  },
  externals: {
    jquery: 'jQuery'
  },
  performance: {
    hints: false
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
    new CopyWebpackPlugin(config.copy)
  ],
  stats: {
    children: true
  },
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
        NODE_ENV: JSON.stringify('production')
      }
    })
  )
  webpackConfig.plugins.push(new webpack.optimize.AggressiveMergingPlugin())
  webpackConfig.optimization.minimizer = [
    new TerserPlugin({
      parallel: true
    }),
    new CssMinimizerPlugin({})
  ]
} else {
  webpackConfig.plugins.push(
    new webpack.DefinePlugin({
      PRODUCTION: JSON.stringify(false),
      'process.env': {
        NODE_ENV: JSON.stringify('development')
      }
    }),
    new FriendlyErrorsWebpackPlugin({
      clearConsole: false
    })
  )
}

const multiConfig = Object.keys(config.entry).map(entry => {
  return {
    ...webpackConfig,
    entry: config.entry[entry],
    name: config.entry[entry],
    output: {
      ...webpackConfig.output,
      filename: `${entry}.js`,
      chunkFilename: `${entry}-chunkFiles/[name]-[contenthash].js`
    },
    plugins: [
      ...webpackConfig.plugins,
      new MiniCssExtractPlugin({
        // Options similar to the same options in webpackOptions.output
        // both options are optional
        filename: `${entry}.css`,
        chunkFilename: `${entry}-chunkFiles/[name]-[contenthash].css`
      })
    ]
  }
})

module.exports = multiConfig
