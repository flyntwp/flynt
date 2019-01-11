const path = require('path')
const webpack = require('webpack')
const HardSourcePlugin = require('hard-source-webpack-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const ExtractCssChunks = require('extract-css-chunks-webpack-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const globImporter = require('node-sass-glob-importer')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const mung = require('express-mung')
// const WriteFilePlugin = require('write-file-webpack-plugin')

module.exports = (function (config) {
  const babelQuery = {
    presets: [
      ['@babel/preset-env', {
        useBuiltIns: 'usage'
      }]
    ]
  }
  // config.production = true
  const output = {
    devServer: {
      writeToDisk: true,
      index: '',
      https: true,
      contentBase: false,
      hot: true,
      proxy: {
        '/': {
          target: 'https://flynt-starter-theme.local.blee.ch',
          changeOrigin: true
          // autoRewrite: true,
          // hostRewrite: true
        }
      },
      // after: function (app, server) {
      //   // console.log(app, server)
      //   // throw('foo')
      //   const fn = mung.write(function (chunk) {
      //     let body = chunk instanceof Buffer ? chunk.toString() : chunk
      //     body = body.replace(/https:\/\/flynt-starter-theme\.local\.blee\.ch/g, 'https://localhost:8081')
      //     return body
      //   })
      //   app.use(fn)
      //   // app.use(function (req, res, next) {
      //   //   // console.log(req, res)
      //   //   // res.body = res.body.replace(/https:\/\/flynt-starter-theme\.local\.blee\.ch/g, 'https://localhost:8081')
      //   //   // throw(res.body)
      //   //   // req.body = ''
      //   //   // res.body = ''
      //   //   const send = res.send
      //   //   res.send = function (string) {
      //   //     let body = string instanceof Buffer ? string.toString() : string
      //   //     body = ''
      //   //     send.call(this, body)
      //   //   }
      //   //   next()
      //   // })
      // }
    },
    mode: config.production ? 'production' : 'development',
    name: 'browser',
    entry: config.entry,
    output: {
      path: path.join(__dirname, 'dist'),
      publicPath: '/app/themes/flynt-starter-theme/dist/'
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
            ExtractCssChunks.loader,
            'css-loader'
          ]
        },
        {
          test: /\.scss$/,
          use: [
            ExtractCssChunks.loader,
            {
              loader: 'css-loader',
              options: {
                url: false,
                import: false
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
      new HardSourcePlugin(),
      new webpack.LoaderOptionsPlugin({
        debug: !config.production
      }),
      new CopyWebpackPlugin(config.copy),
      new ExtractCssChunks({
        // Options similar to the same options in webpackOptions.output
        // both options are optional
        filename: '[name].css',
        chunkFilename: '[name].css',
        hot: true
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
  } else {
    // output.plugins.push(
    //   new WriteFilePlugin()
    // )
  }
  return output
})(require('./gulpfile.js/config').webpack)
