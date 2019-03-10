import './auth.scss'

function importAll (r) {
  r.keys().forEach(r)
}

importAll(require.context('../Components/', true, /auth\.js$/))
