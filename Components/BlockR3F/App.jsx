import ReactDOM from 'react-dom/client'
import { Canvas } from '@react-three/fiber'
// import { ScrollControls } from '@react-three/drei'
import Scene from './Scene.jsx'
import * as THREE from 'three'

export default function (el, props) {
  const root = ReactDOM.createRoot(el)
  root.render(
    <Canvas
      gl={{
        antialias: true,
        toneMapping: THREE.ACESFilmicToneMapping,
        outputColorSpace: THREE.SRGBColorSpace
      }}
      camera={{
        fov: 45,
        near: 0.1,
        far: 200,
        position: [6, 2, 4]
      }}
    >
      {/* <axesHelper args={[5]} /> */}
      <Scene {...props} />
    </Canvas>
  )
}
