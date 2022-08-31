const { merge } = require('webpack-merge')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const common = require('./webpack.common.js')

module.exports = merge(common, {
  mode: 'production',
  output: {
    filename: '[name].[contenthash].js'
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].[contenthash].css'
    }),
    new CopyWebpackPlugin({
      patterns: [
        getCopyConfig('./Components/**/*'),
        getCopyConfig('./assets/**/*')
      ]
    })
  ],
  optimization: {
    minimizer: ['...', new CssMinimizerPlugin()]
  }
})

function getCopyConfig (source) {
  return {
    from: source,
    to: './[path][name].[contenthash][ext]',
    noErrorOnMissing: true,
    globOptions: {
      ignore: [
        '**/*.js',
        '**/*.scss',
        '**/*.php',
        '**/*.twig',
        '**/screenshot.png',
        '**/README.md'
      ]
    }
  }
}
