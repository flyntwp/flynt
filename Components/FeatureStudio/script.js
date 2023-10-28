// import Postmate from 'postmate'

// export default function (el) {
//   const handshake = new Postmate.Model({
//     render: html => {
//       el.innerHTML = html
//     }
//   })
// }
import { connectToParent } from 'penpal'

export default function (el) {
  connectToParent({
    methods: {
      render: (html) => {
        el.innerHTML = html
      }
    }
  })
}
