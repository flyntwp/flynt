import { defineConfig } from 'vite'
import { dest, entries, host, watchFiles } from './build-config.js'
import flynt from './vite-plugin-flynt'
import globImporter from 'node-sass-glob-importer'
import basicSsl from '@vitejs/plugin-basic-ssl'
import FullReload from 'vite-plugin-full-reload'

const isSecure = host.indexOf('https://') === 0

export default defineConfig({
  base: './',
  css: {
    devSourcemap: true,
    preprocessorOptions: {
      scss: {
        importer: globImporter()
      }
    }
  },
  plugins: [
    flynt({ dest, host }),
    FullReload(watchFiles),
    isSecure ? basicSsl() : null
  ],
  server: {
    https: isSecure
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
})
