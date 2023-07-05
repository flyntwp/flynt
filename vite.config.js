import { defineConfig, loadEnv } from 'vite'
import autoprefixer from 'autoprefixer'
import flynt from './vite-plugin-flynt'
import globImporter from 'node-sass-glob-importer'
import FullReload from 'vite-plugin-full-reload'
import fs from 'fs'

const wordpressHost = 'http://localhost:3000'

const dest = './dist'
const entries = [
  './assets/admin.js',
  './assets/admin.scss',
  './assets/main.js',
  './assets/main.scss',
  './assets/print.scss',
  './assets/editor-style.scss'
]
const watchFiles = [
  '*.php',
  'templates/**/*',
  'lib/**/*',
  'inc/**/*',
  './Components/**/*.{php,twig}'
]

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')
  const host = env.VITE_DEV_SERVER_HOST || wordpressHost
  const isSecure = host.indexOf('https://') === 0 && (env.VITE_DEV_SERVER_KEY || env.VITE_DEV_SERVER_CERT)

  return {
    base: './',
    css: {
      devSourcemap: true,
      preprocessorOptions: {
        scss: {
          importer: globImporter()
        }
      },
      postcss: {
        plugins: [autoprefixer()]
      }
    },
    resolve: {
      alias: {
        '@': __dirname
      }
    },
    plugins: [flynt({ dest, host }), FullReload(watchFiles)],
    server: {
      https: isSecure
        ? {
            key: fs.readFileSync(env.VITE_DEV_SERVER_KEY),
            cert: fs.readFileSync(env.VITE_DEV_SERVER_CERT)
          }
        : false,
      host: 'localhost' // preserve conflicts with IpV6
    },
    build: {
      // generate manifest.json in outDir
      manifest: true,
      outDir: dest,
      rollupOptions: {
        // overwrite default .html entry
        input: entries
      }
    }
  }
})
