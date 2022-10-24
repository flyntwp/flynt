import { defineConfig } from 'vite'
import { dest, entries, host } from './build-config.js'
import globImporter from 'node-sass-glob-importer'
import basicSsl from '@vitejs/plugin-basic-ssl'
import * as path from 'path'
import * as fs from 'fs'

export default defineConfig({
  base: './',
  css: {
    preprocessorOptions: {
      scss: {
        importer: globImporter()
      }
    }
  },
  plugins: [
    flyntPlugin(),
    basicSsl()
  ],
  server: {
    https: true
  },
  build: {
    // generate manifest.json in outDir
    manifest: true,
    outDir: dest,
    rollupOptions: {
      // overwrite default .html entry
      input: Object.values(entries)
    }
  }
})

let exitHandlersBound = false
function flyntPlugin() {
  const hotFile = path.join(dest, 'hot')
  let viteDevServerUrl
  return {
      name: 'flynt',
      enforce: 'post',
      // transform(code) {
      //     if (resolvedConfig.command === 'serve') {
      //         return code.replace(/__laravel_vite_placeholder__/g, viteDevServerUrl)
      //     }
      // },
      configureServer(server) {
          const envDir = process.cwd()
          const appUrl = host

          server.httpServer?.once('listening', () => {
              const address = server.httpServer?.address()

              const isAddressInfo = (x) => typeof x === 'object'
              if (isAddressInfo(address)) {
                // console.log(address,server)
                  viteDevServerUrl = resolveDevServerUrl(address, server.config)
                  fs.writeFileSync(hotFile, viteDevServerUrl)

                  setTimeout(() => {
                      // server.config.logger.info(`\n  ${colors.red(`${colors.bold('LARAVEL')} ${laravelVersion()}`)}  ${colors.dim('plugin')} ${colors.bold(`v${pluginVersion()}`)}`)
                      // server.config.logger.info('')
                      // server.config.logger.info(`  ${colors.green('➜')}  ${colors.bold('APP_URL')}: ${colors.cyan(appUrl.replace(/:(\d+)/, (_, port) => `:${colors.bold(port)}`))}`)
                      server.config.logger.info(`  ➜  APP_URL: ${appUrl.replace(/:(\d+)/, (_, port) => `:${port}`)}`)
                  }, 100)
              }
          })

          if (! exitHandlersBound) {
              const clean = () => {
                  if (fs.existsSync(hotFile)) {
                      fs.rmSync(hotFile)
                  }
              }

              process.on('exit', clean)
              process.on('SIGINT', process.exit)
              process.on('SIGTERM', process.exit)
              process.on('SIGHUP', process.exit)

              exitHandlersBound = true
          }

          return () => server.middlewares.use((req, res, next) => {
              if (req.url === '/index.html') {
                  res.statusCode = 404

                  res.end(
                      `please open ${appUrl}`
                  )
              }

              next()
          })
      }
  }
}

/**
 * Resolve the dev server URL from the server address and configuration.
 */
 function resolveDevServerUrl(address, config) {
  const configHmrProtocol = typeof config.server.hmr === 'object' ? config.server.hmr.protocol : null
  const clientProtocol = configHmrProtocol ? (configHmrProtocol === 'wss' ? 'https' : 'http') : null
  const serverProtocol = config.server.https ? 'https' : 'http'
  const protocol = clientProtocol ?? serverProtocol

  const configHmrHost = typeof config.server.hmr === 'object' ? config.server.hmr.host : null
  const configHost = typeof config.server.host === 'string' ? config.server.host : null
  const serverAddress = isIpv6(address) ? `[${address.address}]` : address.address
  const host = configHmrHost ?? configHost ?? serverAddress

  const configHmrClientPort = typeof config.server.hmr === 'object' ? config.server.hmr.clientPort : null
  const port = configHmrClientPort ?? address.port

  return `${protocol}://${host}:${port}`
}
function isIpv6(address) {
  return address.family === 'IPv6'
      // In node >=18.0 <18.4 this was an integer value. This was changed in a minor version.
      // See: https://github.com/laravel/vite-plugin/issues/103
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore-next-line
      || address.family === 6;
}
