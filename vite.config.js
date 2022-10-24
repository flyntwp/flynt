import { defineConfig } from 'vite'
import { dest, entries, host } from './build-config.js'
import globImporter from 'node-sass-glob-importer'
import basicSsl from '@vitejs/plugin-basic-ssl'

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
    basicSsl(),
  ],
  server: {
    https: true,
  },
  build: {
    // generate manifest.json in outDir
    manifest: true,
    outDir: dest,
    rollupOptions: {
      // overwrite default .html entry
      input: Object.values(entries),
    },
  },
})
