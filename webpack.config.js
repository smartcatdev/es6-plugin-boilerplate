const { 
  assign,
  flatMap
} = require('lodash')
const { 
  build: {
    entry,
    alias,
    output
  } 
} = require('./build.config')
const Manifest = require('webpack-manifest-plugin')

const generateManifest = (seed, files) => files.reduce((manifest, {name, path}) => {
  if (path.endsWith('.js')) {
    return {...manifest, js: { [name]: path }}
  } else if (path.endsWith('.css')) {
    return {...manifest, css: { [name]: path }}
  }
}, seed)

module.exports = {
  entry,
  output,
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        loader: 'babel-loader'
      },
      {
        test: /\.scss$/,
        use: [
          { loader: 'style-loader' },
          { loader: 'css-loader' },
          { loader: 'sass-loader' }
        ]
      }
    ]
  },
  resolve: {
    alias,
    extensions: [
      '.js', 
      '.jsx'
    ]
  },
  optimization: {
    runtimeChunk: false,
    splitChunks: {
      cacheGroups: {
        common: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendor',
          chunks: 'all',
        },
      }
    }
  },
  plugins: [
    new Manifest({
      generate: generateManifest,
      seed: {
        js: {},
        css: {}
      }
    })
  ]
}
