import './scripts/publicPath'
import './admin.scss'

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /\/admin\.js$/))
importAll(require.context('../lib/Customizer/', true, /\/control\.js$/))
