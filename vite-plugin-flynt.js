import path from 'path'
import fs from 'fs'

let exitHandlersBound = false
export default function ({ dest, host }) {
  const hotFile = path.join(dest, 'hot')
  let viteDevServerUrl, resolvedConfig
  return {
    name: 'flynt',
    enforce: 'post',
    config: () => {
      return {
        publicDir: false,
        server: {
          origin: '__flynt_vite_placeholder__'
        }
      }
    },

    configResolved (config) {
      resolvedConfig = config
    },
    transform (code) {
      if (resolvedConfig.command === 'serve') {
        return code.replace(/__flynt_vite_placeholder__/g, viteDevServerUrl)
      }
    },
    configureServer (server) {
      const appUrl = host

      server.httpServer?.on('listening', () => {
        const address = server.httpServer?.address()

        const isAddressInfo = (x) => typeof x === 'object'
        if (isAddressInfo(address)) {
          viteDevServerUrl = resolveDevServerUrl(address, server.config)
          fs.writeFileSync(hotFile, viteDevServerUrl)

          setTimeout(() => {
            const isSecure = host.indexOf('https://') === 0 && (server.httpServer.key || server.httpServer.cert)
            if (!isSecure) {
              server.config.logger.info('  ➜ Please define VITE_DEV_SERVER_KEY and VITE_DEV_SERVER_CERT inside “.env” to enable ssl support for the vite dev server.')
            }

            server.config.logger.info(`  ➜ APP_URL: ${appUrl.replace(/:(\d+)/, (_, port) => `:${port}`)}`)
          }, 100)
        }
      })

      if (!exitHandlersBound) {
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
          res.end(`please open ${appUrl}`)
        }
        next()
      })
    }
  }
}

/**
 * Resolve the dev server URL from the server address and configuration.
 */
function resolveDevServerUrl (address, config) {
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
function isIpv6 (address) {
  return address.family === 'IPv6' ||
      // In node >=18.0 <18.4 this was an integer value. This was changed in a minor version.
      // See: https://github.com/laravel/vite-plugin/issues/103
      // eslint-disable-next-line
      address.family === 6
}
