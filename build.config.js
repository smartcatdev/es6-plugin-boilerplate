module.exports = {
  build: {
    entry: { 
      'bundle': `${__dirname}/src/index.js` 
    },
    output: {
      filename: '[name].js',
      path: `${__dirname}/build`,
    },
    alias: {
      'scss': `${__dirname}/scss`
    }
  },
  release: {
    output: {
      path: `${__dirname}/build`,
      filename: 'release.zip'
    },
    archive: [
      "LICENSE",
      "package.json",
      "src/**",
      "scss/**",
      "build/**",
      "includes/**",
      "**/*.php"
    ]
  }
}
