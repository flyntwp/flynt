import { buildRefs, getJSON } from '@/assets/scripts/helpers'
import App from './App.jsx'

export default function (el) {
  const data = getJSON(el)
  const ref = buildRefs(el)

  App(ref.canvasPlaceholder, data)
}
