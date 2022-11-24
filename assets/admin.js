// import './scripts/publicPath'
if (import.meta.env.DEV) {
  import('@vite/client')
}

import.meta.glob('../Components/**/admin.js', { eager: true })
