#!/usr/bin/env node

const fs = require('fs'),
      ar = require('archiver')
const { 
  release: {
    output,
    archive
  } 
} = require('../build.config')

const OUTPUT_PATH = `${output.path}/${output.filename}`

const ostream = fs.createWriteStream(OUTPUT_PATH),
      zip = ar('zip', {
        zlib: { level: 9 }
      })

zip.pipe(ostream)

ostream.on('close', () => console.info(`Completed writing archive to ${OUTPUT_PATH}`))

zip.on('warning', err => {
  if (err.code === 'ENOENT') {
    console.warn(err.message)
  } else {
    throw err
  }
})

zip.on('error', err => { throw err })

archive.forEach(
  item => zip.glob(item)
)

// Good to go
zip.finalize()
