import './scripts/publicPath'
import './customizerControls.scss'

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../lib/Customizer/Control/', true, /\/control\.js$/))
