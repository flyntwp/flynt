const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const globImporter = require('node-sass-glob-importer')
const WebpackAssetsManifest = require('webpack-assets-manifest')

const { dest, entries } = require('./build-config.js')

const babelQuery = {
  presets: [
    [
      '@babel/preset-env',
      {
        useBuiltIns: 'usage',
        corejs: 'core-js@3',
        bugfixes: true
      }
    ]
  ],
  cacheDirectory: true,
  sourceType: 'unambiguous',
  plugins: [
    '@babel/plugin-transform-runtime'
  ]
}

const config = {
  output: {
    filename: '[name].js',
    path: path.join(__dirname, dest),
    clean: true,
    assetModuleFilename: '[path][name].[contenthash][ext]'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: [
          /node_modules\/(css-loader|core-js|regenerator-runtime)\//
        ],
        use: [
          {
            loader: 'babel-loader',
            options: babelQuery
          }
        ]
      },
      {
        test: /\.(png|jpe?g|gif|svg|eot|ttf|woff|woff2)$/i,
        // More information here https://webpack.js.org/guides/asset-modules/
        type: 'asset/resource'
      },
      {
        test: /\.css$/,
        use: [MiniCssExtractPlugin.loader, 'css-loader']
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  require('autoprefixer')({
                    grid: true
                  })
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
  plugins: [
    new WebpackAssetsManifest({
      output: path.join(__dirname, dest, 'rev-manifest.json'),
      publicPath: dest
    })
  ]
}

if (Array.isArray(entries)) {
  module.exports = entries.map(entry => ({ ...config, entry }))
} else {
  module.exports = { ...config, entry: entries }
}
