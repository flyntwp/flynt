import { useRef } from 'react'
import { useFrame } from '@react-three/fiber'
import { OrbitControls, Html, useGLTF } from '@react-three/drei'
// import { useControls } from 'leva'

export default function Experience (props) {
  const threeModel = useGLTF(props.gltfModelUrl)
  const threeRef = useRef()

  // const { position, bgColor } = useControls('Model', {
  //   position: {
  //     value: { x: props.modelPosition.x * 1, y: props.modelPosition.y * 1, z: props.modelPosition.z * 1 },
  //     x: { min: -5, max: 5, step: 0.1 },
  //     y: { min: -5, max: 5, step: 0.1 },
  //     z: { min: -5, max: 5, step: 0.1 }
  //   },
  //   bgColor: props.backgroundColor
  // })
  // const scroll = useScroll()

  useFrame((state, delta) => {
    // const offset = 1 - scroll.offset
    // const angle = state.clock.elapsedTime
    // state.camera.position.x = Math.sin(angle) * 8
    // state.camera.position.z = Math.cos(angle) * 8
    // state.camera.lookAt(0, 0, 0)
    // state.camera.position.set(Math.sin(offset) * -10, Math.atan(offset * Math.PI * 2) * 5, Math.cos((offset * Math.PI) / 3) * -10)
    // state.camera.lookAt(0, 0, 0)
    props.enableAutoRotation && (threeRef.current.rotation.y += delta * 0.1)
  })

  return (
    <>
      <OrbitControls
        enabled={!!props.enableOrbitControl}
        maxDistance={12}
        minDistance={6}
        maxPolarAngle={Math.PI / 2}
        enablePan={false}
        maxAzimuthAngle={Math.PI - Math.PI / 6}
        minAzimuthAngle={Math.PI / 8}
      />

      <color attach='background' args={[props.backgroundColor]} />

      <directionalLight position={[1, 2, 3]} intensity={4.5} />
      <ambientLight intensity={1.5} />

      <primitive
        object={threeModel.scene} ref={threeRef}
        position={[props.modelPosition.x, props.modelPosition.y, props.modelPosition.z]}
        scale={props.modelScale * 1}
      >
        {props.tooltips.length
          ? props.tooltips.map((tooltip, i) => {
            return (
              <Html
                key={i}
                position={[tooltip.position.x * 1, tooltip.position.y * 1, tooltip.position.z * 1]}
                wrapperClass='r3f-tooltip'
                center={false}
                distanceFactor={10}
                occlude={[threeRef]}
              >{tooltip.title}
              </Html>
            )
          })
          : null}
      </primitive>
    </>
  )
}
