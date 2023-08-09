import { promises as fs } from 'fs'
import {
  importDirectory,
  cleanupSVG,
  runSVGO,
  parseColors,
  isEmptyColor
} from '@iconify/tools'

export default function ({ directory }) {
  return {
    name: 'import-icons',
    configureServer (server) {
      async function onWatchChange (filepath) {
        if (filepath.endsWith('.svg')) {
          importIcons(directory)
        }
      }

      server.watcher.on('add', onWatchChange)
      server.watcher.on('change', onWatchChange)
      server.watcher.on('unlink', onWatchChange)
    },
    buildStart (options) {
      importIcons(directory)
    }
  }
}

async function importIcons (directory) {
  // Import icons
  const iconsSVG = await importDirectory(directory, {
    prefix: 'interlude'
  })

  // Validate, clean up, fix palette and optimise
  await iconsSVG.forEach(async (name, type) => {
    if (type !== 'icon') {
      return
    }

    const svg = iconsSVG.toSVG(name)
    if (!svg) {
      // Invalid icon
      iconsSVG.remove(name)
      return
    }

    // Clean up and optimise icons
    try {
      // Clean up icon code
      cleanupSVG(svg)

      // Assume icon is monotone: replace color with currentColor, add if missing
      // If icon is not monotone, remove this code
      await parseColors(svg, {
        defaultColor: 'currentColor',
        callback: (attr, colorStr, color) => {
          return !color || isEmptyColor(color)
            ? colorStr
            : 'currentColor'
        }
      })

      // Optimise
      runSVGO(svg)
    } catch (err) {
      // Invalid icon
      console.error(`Error parsing ${name}:`, err)
      iconsSVG.remove(name)
      return
    }

    // Update icon
    iconsSVG.fromSVG(name, svg)
  })

  // Export as IconifyJSON
  const exported = JSON.stringify(iconsSVG.export(), null, '\t') + '\n'

  // Save to file
  await fs.writeFile(`${directory}/${iconsSVG.prefix}.json`, exported, 'utf8')
}
