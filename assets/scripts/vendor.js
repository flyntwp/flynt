import 'file-loader?name=vendor/console.js!console-polyfill'
import 'file-loader?name=vendor/babel-polyfill.js!babel-polyfill/dist/polyfill'
import 'file-loader?name=vendor/slick.js!slick-carousel'
import 'file-loader?name=vendor/slick.css!slick-carousel/slick/slick.css'
(function importSlickFonts (fontName) {
  require(`file-loader?name=vendor/slick/[name].[ext]!slick-carousel/slick/fonts/${fontName}`)
})()
